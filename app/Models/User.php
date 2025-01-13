<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Assuming you have a 'role' field in your users table
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role; // If role is stored as a string in the users table
    }

    /**
     * Example of many-to-many relationship with Role model if using pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Check if the user has a specific role (if using many-to-many relationship).
     *
     * @param string $role
     * @return bool
     */
    public function hasRoleInPivot(string $role): bool
    {
        return $this->roles()->where('role_name', $role)->exists(); // Adjust 'role_name' based on your Role model
    }
    
    use HasFactory;

    // Define the relationship to orders
    public function orders()
    {
        return $this->hasMany(Order::class); // Assuming an Order model exists
    }
}
