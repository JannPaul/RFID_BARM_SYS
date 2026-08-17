<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mass assignable fields.
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'employeeid',
        'email',
        'password',
        'access_level',
        'status',
    ];

    /**
     * Hidden fields.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Field casts.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Use Employee ID for authentication.
     */
    public function username()
    {
        return 'employeeid';
    }

    /**
     * User's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim(
            $this->firstname . ' ' . $this->lastname
        );
    }

    /**
     * Attendance records.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(
            Attendance::class
        );
    }
}