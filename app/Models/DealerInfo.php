<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerInfo extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'dealer_name', 'dealer_address', 'company_phone', 'cell_phone', 'dealer_email', 'dealer_username', 'dealer_password', 'landing_page', 'page_access', 'show_record_date'
    ];
}
