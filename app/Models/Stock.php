<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rack_number', 'aisle', 'weight', 'item_number', 'name', 'note', 'temp'
    ];
}
