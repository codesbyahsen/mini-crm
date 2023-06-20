<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'client_name',
        'total_cost',
        'deadline'
    ];

    public function deadline(): Attribute
    {
        return new Attribute(
            get: fn ($value) => date('d-M-Y', strtotime($value))
        );
    }
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
}
