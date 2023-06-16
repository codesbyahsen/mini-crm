<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logo',
        'name',
        'display_name',
        'email',
        'phone',
        'mobile',
        'founded_in',
        'website',
        'address_line_one',
        'address_line_two',
        'city',
        'state',
        'country',
        'password'
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
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function logo(): Attribute
    {
        return new Attribute(
            get: fn ($value) => isset($value) && !empty($value) ? asset('storage/' . $value) : asset('images/building.jpg')
        );
    }

    public function website(): Attribute
    {
        return new Attribute(
            set: fn ($value) => str_contains($value, 'http') ? $value : 'https://' . $value
        );
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
