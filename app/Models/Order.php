<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_status',
        'shipping_status',
        // Add any other fields you need
    ];

    
        public function products()
        {
            return $this->belongsToMany(Product::class)
                        ->withPivot('quantity') // Include the quantity in the pivot table
                        ->withTimestamps();
        }

        public function customer()
        {
            return $this->belongsTo(Customer::class);
        }
    }


