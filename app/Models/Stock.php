<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'reorder_level',
        'stock',
    ];

    /**
     * Define the relationship with the Product model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if the stock is below the reorder level.
     *
     * @return bool
     */
    public function isBelowReorderLevel()
    {
        return $this->quantity_available <= $this->reorder_level;
    }

    /**
     * Adjust the stock quantity.
     *
     * @param  int  $quantity
     * @return void
     */
    public function adjustStock(int $quantity)
    {
        // Ensure that quantity doesn't go below 0
        $this->quantity_available = max(0, $this->quantity_available + $quantity);

        // Save the updated stock
        $this->save();
    }

    /**
     * Get the name of the product associated with the stock.
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product ? $this->product->name : 'Unknown Product';
    }
}
