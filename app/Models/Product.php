<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Available Stock
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    // Format Price to Rupiah
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format((float)$this->price, 0, ',', '.');
    }

    // decrease stock
    public function decreaseStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
        }
    }

    // increase stock
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
