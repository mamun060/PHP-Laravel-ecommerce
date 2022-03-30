<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
