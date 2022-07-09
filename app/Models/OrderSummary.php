<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSummary extends Model
{
    // use SoftDeletes;
    protected $table = 'ordersummary';
    protected $fillable = [
        'ORDER#', 'CUST PO', 'COMPANY'
    ];
}
