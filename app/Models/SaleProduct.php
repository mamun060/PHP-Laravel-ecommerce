<?php

namespace App\Models;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
