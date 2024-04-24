<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsPriceList extends Model
{
    use HasFactory;

    protected $fillable = ['products_id', 'price_lists_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_price_lists', 'id', 'products_id');
    }

    public function priceList()
    {
        return $this->belongsTo(PriceList::class, 'price_lists', 'id', 'price_lists_id');
    }
}
