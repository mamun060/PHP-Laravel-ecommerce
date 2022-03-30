<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{

    protected $guarded = ['id'];
    
    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
}
