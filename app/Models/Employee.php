<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Authenticatable
{
    use HasFactory, HasRoles;

    /**
     * Authenticates users from employees table
     */
    protected $guard = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'avatar',
        'first_name',
        'last_name',
        'display_name',
        'email',
        'phone',
        'mobile',
        'gender',
        'date_of_birth',
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

    public function avatar(): Attribute
    {
        return new Attribute(
            get: fn ($value) => isset($value) && !empty($value) ? asset('storage/' . $value) : null
        );
    }

    public function displayName(): Attribute
    {
        $titles = ['Male' => 'Mr.', 'Female' => 'Ms.', 'Other' => null];
        return new Attribute(
            get: fn ($value) => ($titles[$this->gender] ?? '') . ' ' . $value
        );
    }

    public function dateOfBirth(): Attribute
    {
        return new Attribute(
            get: fn ($value) => !empty($value) ? date('Y-m-d', strtotime($value)) : null
        );
    }

    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddress(): ?string
    {
        return (($this->address_line_one ? $this->address_line_one . ', ' : null) . ($this->address_line_two ? $this->address_line_two . ', ' : null) . ($this->city ? $this->city . ', ' : null) . ($this->state ? $this->state . ', ' : null) . ($this->country ? $this->country . '.' : null) == null ? null : ($this->address_line_one ? $this->address_line_one . ', ' : null) . ($this->address_line_two ? $this->address_line_two . ', ' : null) . ($this->city ? $this->city . ', ' : null) . ($this->state ? $this->state . ', ' : null) . ($this->country ? $this->country . '.' : null));
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
