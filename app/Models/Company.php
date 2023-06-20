<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Authenticates users from companies table
     */
    protected $guard = 'company';

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
            get: fn ($value) => isset($value) && !empty($value) ? asset('storage/' . $value) : asset('images/default-company.jpg')
        );
    }

    public function website(): Attribute
    {
        return new Attribute(
            set: fn ($value) => !empty($value) ? (str_contains($value, 'http') ? $value : 'https://' . $value) : null
        );
    }

    public function getFullAddress(): ?string
    {
        return (($this->address_line_one ? $this->address_line_one . ', ' : null) . ($this->address_line_two ? $this->address_line_two . ', ' : null) . ($this->city ? $this->city . ', ' : null) . ($this->state ? $this->state . ', ' : null) . ($this->country ? $this->country . '.' : null) == null ? null : ($this->address_line_one ? $this->address_line_one . ', ' : null) . ($this->address_line_two ? $this->address_line_two . ', ' : null) . ($this->city ? $this->city . ', ' : null) . ($this->state ? $this->state . ', ' : null) . ($this->country ? $this->country . '.' : null));
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
