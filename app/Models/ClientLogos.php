<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLogos extends Model
{
    public $table = 'client_logos';
    public $timestamps = false;
    protected $guarded = ['id'];

}
