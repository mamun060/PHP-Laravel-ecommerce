<?php

namespace App\Models;

use App\Models\Custom\CustomServiceOrder;
use App\Models\Product;
use App\Models\SaleProduct;
use App\Models\CustomerType;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function customerTypes()
    {
        return $this->hasMany(CustomerType::class, 'customer_type');
    }

    public function customerType($type='customize')
    {
        return $this->hasOne(CustomerType::class, 'customer_id')->where('customer_type', $type);
    }
    
}
  