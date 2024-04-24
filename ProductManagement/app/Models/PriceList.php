<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PriceList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'agency_id'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function productsPriceLists()
    {
        return $this->hasMany(ProductsPriceList::class, 'price_lists_id', 'id');
    }
}
