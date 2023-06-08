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

    protected $fillable = ['name', 'email', 'logo', 'website'];

    public function logo(): Attribute
    {
        return new Attribute(
            get: fn ($value) => isset($value) && !empty($value) ? asset('storage/' . $value) : null
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
