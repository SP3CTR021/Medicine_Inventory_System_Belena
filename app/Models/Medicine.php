<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Medicine extends Model
{
    /** @use HasFactory<\Database\Factories\MedicineFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'generic_name',
        'category',
        'quantity',
        'expiration_date',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'expiration_date' => 'date',
            'price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired')
            ->orWhere('expiration_date', '<', now()->toDateString());
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->where('quantity', '<=', 10)
            ->where('quantity', '>', 0);
    }

    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Auto-update status based on quantity and expiration date.
     */
    public static function determineStatus(int $quantity, string $expirationDate): string
    {
        if ($quantity <= 0) {
            return 'out_of_stock';
        }

        if ($expirationDate < now()->toDateString()) {
            return 'expired';
        }

        if ($quantity <= 10) {
            return 'low_stock';
        }

        return 'available';
    }
}
