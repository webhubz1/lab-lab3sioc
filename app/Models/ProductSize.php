<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory trait
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory; // Enable factory functionality

    protected $fillable = ['product_id', 'size']; // Fillable attributes
}
