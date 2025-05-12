<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'notes',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getTotalOrdersAmount(): float
    {
        return $this->sales()->sum('total_amount');
    }

    public function getLastOrderDate(): ?string
    {
        $lastSale = $this->sales()
            ->orderBy('order_date', 'desc')
            ->first();

        return $lastSale?->order_date;
    }
}
