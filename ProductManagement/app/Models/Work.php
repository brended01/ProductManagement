<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'qty', 'products_id', 'agency_id', 'price_lists_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function priceList()
    {
        return $this->belongsTo(PriceList::class, 'price_lists_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
