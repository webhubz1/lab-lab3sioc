<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'image',
        'quantity',
        'stock',
        'discount',
        'size',
    ];

    /**
     * Define a relationship with the Stock model.
     * Assuming a product has one stock record.
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * Define a relationship with the Category model.
     * Assuming a product belongs to one category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define a relationship with the Supplier model.
     * Assuming a product belongs to one supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Calculate the discounted price of the product.
     *
     * @param float $discountPercentage
     * @return float
     */
    public function calculateDiscountedPrice(float $discountPercentage): float
    {
        return $this->price - ($this->price * ($discountPercentage / 100));
    }

    /**
     * Check if the product is in stock.
     * Returns true if stock exists and quantity_available is greater than 0.
     *
     * @return bool
     */
    public function isInStock(): bool
    {
        return $this->stock && $this->stock->quantity_available > 0;
    }

    /**
     * Get the quantity available for the product.
     *
     * @return int
     */
    public function getQuantityAvailable(): int
    {
        return $this->stock ? $this->stock->quantity_available : 0;
    }

    /**
     * Get the product name with category for display purposes.
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->product_name . ' (' . ($this->category ? $this->category->name : 'No Category') . ')';
    }

    /**
     * Get the product price with a discount applied.
     * Optionally provide the discount percentage.
     *
     * @param  float  $discountPercentage
     * @return float
     */
    public function priceWithDiscount(float $discountPercentage = 0): float
    {
        if ($discountPercentage > 0) {
            return $this->calculateDiscountedPrice($discountPercentage);
        }

        return $this->price;
    }

    /**
     * Retrieve the full description of the product, including additional category and supplier info.
     *
     * @return string
     */ 
    public function getFullDescription(): string
    {
        $description = $this->description;
        $category = $this->category ? $this->category->name : 'Uncategorized';
        $supplier = $this->supplier ? $this->supplier->name : 'Unknown Supplier';
        
        return "{$description} - Category: {$category}, Supplier: {$supplier}";
    }
    public function getDiscountedPriceAttribute()
{
    if ($this->discount > 0) {
        return $this->price - ($this->price * ($this->discount / 100));
    }
    return $this->price;
}
public function sizes()
{
    return $this->hasMany(ProductSize::class);
}
}
    