<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Custom\CustomServiceCustomer;
use App\Models\Customer;

class CustomServiceOrder extends Model
{
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(CustomServiceProduct::class,'custom_service_product_id');
    }

}
