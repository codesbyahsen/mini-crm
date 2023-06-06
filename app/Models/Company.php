<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'logo', 'website'];

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
