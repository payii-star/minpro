<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * Fillable attributes.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'photos',    // JSON array: ["products/abc.jpg", ...]
        'is_active',
    ];

    /**
     * Type casts.
     */
    protected $casts = [
        'photos'    => 'array',
        'price'     => 'decimal:2',
        'stock'     => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Boot model events for auto-generating slug when missing.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $base = Str::slug($product->name ?? 'product');
                $product->slug = $base . '-' . Str::random(6);
            }
        });

        static::updating(function (Product $product) {
            // optional: if slug removed/empty on update, regenerate from name
            if (empty($product->slug) && ! empty($product->name)) {
                $base = Str::slug($product->name);
                $product->slug = $base . '-' . Str::random(6);
            }
        });
    }

    /**
     * Ambil foto pertama (path relatif) atau null.
     * Contoh return: "products/abc.jpg" atau null
     */
    public function getCoverAttribute(): ?string
    {
        $photos = $this->photos ?? [];
        return isset($photos[0]) && $photos[0] !== '' ? $photos[0] : null;
    }

    /**
     * Ambil URL penuh untuk cover (dipakai di <img src="...">).
     * - Jika stored value sudah full URL (http/https) => kembalikan langsung
     * - Jika relative path => kembalikan asset('storage/...') (pastikan storage:link sudah dijalankan)
     * - Jika tidak ada cover => null (blade bisa fallback)
     */
    public function getCoverUrlAttribute(): ?string
    {
        $cover = $this->cover;

        if (! $cover) {
            return null; // di blade gunakan fallback: $product->cover_url ?? asset('model.jpg')
        }

        // kalau sudah URL (http/https), pakai langsung
        if (preg_match('/^https?:\\/\\//i', $cover)) {
            return $cover;
        }

        // jika cover sudah diawali "storage/" (jarang), pastikan tidak duplicate
        if (str_starts_with($cover, 'storage/')) {
            return asset($cover);
        }

        // default: path relatif di storage/app/public -> diakses via /storage/...
        return asset('storage/' . ltrim($cover, '/'));
    }

    /**
     * Format harga untuk tampilan (contoh: "150.000")
     * Pemakaian: $product->formatted_price
     */
    public function getFormattedPriceAttribute(): string
    {
        $price = $this->price ?? 0;
        return number_format((float)$price, 0, ',', '.');
    }
}
