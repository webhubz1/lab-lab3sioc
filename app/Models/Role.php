<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Define fillable fields such as 'name'

    // Define the inverse belongsTo relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
