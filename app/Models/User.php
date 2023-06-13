<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Authorizable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'name',
        'display_name',
        'email',
        'phone',
        'mobile',
        'date_of_birth',
        'address_line_one',
        'address_line_two',
        'city',
        'state',
        'country',
        'password',
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

    public function avatar(): Attribute
    {
        return new Attribute(
            get: fn ($value) => isset($value) && !empty($value) ? asset('storage/' . $value) : null
        );
    }

    public function displayName(): Attribute
    {
        $titles = ['Male' => 'Mr.', 'Female' => 'Ms.'];
        return new Attribute(
            get: fn ($value) => $titles[$this->gender] . ' ' . $value
        );
    }

    public function getFullAddress()
    {
        return (($this->address_line_one ? $this->address_line_one . ', ' : null) . ($this->address_line_two ? $this->address_line_two . ', ' : null) . ($this->city ? $this->city . ', ' : null) . ($this->state ? $this->state . ', ' : null) . ($this->country ? $this->country . '.' : null) == null ? null : ($this->address_line_one ? $this->address_line_one . ', ' : null) . ($this->address_line_two ? $this->address_line_two . ', ' : null) . ($this->city ? $this->city . ', ' : null) . ($this->state ? $this->state . ', ' : null) . ($this->country ? $this->country . '.' : null));
    }
}
