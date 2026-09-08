<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FanCalculation extends Model
{
    protected $fillable = [
        'public_id',
        'tab',
        'title',
        'inputs',
        'results',
        'selected_items',
        'customer_name',
        'customer_phone',
        'customer_email',
        'company_name',
        'tax_number',
        'project_address',
        'notes',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'inputs' => 'array',
        'results' => 'array',
        'selected_items' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->public_id)) {
                $model->public_id = self::generateUniquePublicId();
            }
        });
    }

    public static function generateUniquePublicId(): string
    {
        do {
            $id = 'EST-' . strtoupper(Str::random(6));
        } while (self::where('public_id', $id)->exists());

        return $id;
    }

    public static function generatePublicId(): string
    {
        return self::generateUniquePublicId();
    }

    public function getTaxCodeAttribute(): ?string
    {
        return $this->tax_number;
    }

    public function setTaxCodeAttribute(?string $value): void
    {
        $this->attributes['tax_number'] = $value;
    }

    public function getCustomerNoteAttribute(): ?string
    {
        return $this->notes;
    }

    public function setCustomerNoteAttribute(?string $value): void
    {
        $this->attributes['notes'] = $value;
    }

    public function getPublicUrlAttribute(): string
    {
        return route('client.calculator.estimation', ['publicId' => $this->public_id]);
    }

    public function getPdfUrlAttribute(): string
    {
        return route('client.calculator.pdf', ['publicId' => $this->public_id]);
    }

    public function getTabLabelAttribute(): string
    {
        return match ($this->tab) {
            'cooling-pad' => 'Làm mát bằng Cooling Pad',
            'thong-gio-phong' => 'Thông gió văn phòng, phòng bếp & WC',
            default => 'Thông gió – Hút khí tổng thể',
        };
    }
}
