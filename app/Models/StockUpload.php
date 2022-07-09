<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockUpload extends Model
{
    protected $fillable = [
        'rack_number', 'qty', 'created_at', 'updated_at'
    ];
}
