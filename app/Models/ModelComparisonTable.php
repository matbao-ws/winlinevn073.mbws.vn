<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModelComparisonTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'columns',
        'show_price',
        'show_action_btn',
        'is_active',
    ];

    protected $casts = [
        'columns' => 'array',
        'show_price' => 'boolean',
        'show_action_btn' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ModelComparisonItem::class, 'table_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'model_comparison_table_id');
    }
}
