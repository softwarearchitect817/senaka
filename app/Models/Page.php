<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    const PAGES = [
        "search_window" => 1,
        "stock_window" => 2,
        "edit_record" => 3,
        "upload_request" => 4,
        "database" => 5,
        "rack_info" => 6,
        "settings" => 7,
        "users" => 8,
        "capacity_reset" => 9,
        "location_information" => 10,
        "covid_19_questions" => 11,
        "covid_19_data" => 12,
        "departments" => 13,
        "window_relocate" => 14,
        "complete_order" => 15,
        "dealer_registration" => 16,
        "dealer" => 17,
        "dealer_info" => 18,
        "dealers" => 19,
        "order_search" => 20
    ];

    protected $guarded = [
        "id", "created_at", "updated_at"
    ];
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
