<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sale_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id',
        'variant_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relationship: SaleItem belongs to a Sale.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relationship: SaleItem belongs to a Variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    /**
     * Accessor to get a display string for the sale item.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->variant->product->name} - {$this->variant->size}/{$this->variant->color} x {$this->quantity}";
    }

    /**
     * Calculate subtotal automatically when saving.
     */
    protected static function booted()
    {
        static::saving(function ($saleItem) {
            $saleItem->subtotal = $saleItem->unit_price * $saleItem->quantity;
        });
    }
}
