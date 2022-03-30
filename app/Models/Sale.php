<?php

namespace App\Models;

use App\Models\SaleProduct;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }
}
