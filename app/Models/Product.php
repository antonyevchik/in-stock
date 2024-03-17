<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function track()
    {
        $this->stock->each->track(
            fn($stock) => $this->recordHistory($stock)
        );
    }

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function recordHistory(Stock $stock)
    {
        return $this->history()->create([
            'price'      => $stock->price,
            'in_stock'   => $stock->in_stock,
            'stock_id' => $stock->id
        ]);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
