<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelComparisonItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'product_id',
        'model_name',
        'specs',
        'custom_price',
        'custom_url',
        'sort_order',
    ];

    protected $casts = [
        'specs' => 'array',
        'custom_price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(ModelComparisonTable::class, 'table_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getUrl(?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale() ?: 'vi';

        if ($this->product) {
            return route('client.products.detail', [
                'locale' => $locale,
                'slug' => $this->product->canonicalSlug($locale),
            ]);
        }

        return $this->custom_url ?: '#';
    }

    public function getEffectivePrice(): ?float
    {
        if ($this->product && $this->product->price !== null) {
            return (float) $this->product->price;
        }

        return $this->custom_price !== null ? (float) $this->custom_price : null;
    }

    public function getFormattedPrice(): string
    {
        $price = $this->getEffectivePrice();

        if ($price === null || $price <= 0) {
            return 'Liên hệ';
        }

        return number_format($price, 0, ',', '.') . ' đ';
    }

    public function getEffectiveComparePrice(): ?float
    {
        if ($this->product && $this->product->compare_at_price !== null) {
            $compare = (float) $this->product->compare_at_price;
            $price = (float) $this->product->price;
            return $compare > $price ? $compare : null;
        }

        return null;
    }

    public function getFormattedComparePrice(): ?string
    {
        $compare = $this->getEffectiveComparePrice();

        if ($compare === null || $compare <= 0) {
            return null;
        }

        return number_format($compare, 0, ',', '.') . ' đ';
    }

    public function getSpecValue(string $columnName): string
    {
        $specs = $this->specs ?? [];
        return isset($specs[$columnName]) ? (string) $specs[$columnName] : '—';
    }
}
