<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
