<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Covid19Data;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded  = [
        "id","created_at","updated_at"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pagesAccess()
    {
        return $this->belongsToMany('App\Models\Page');
    }

    public function landing()
    {
        return $this->belongsTo('App\Models\Page', 'landing_page', 'id');
    }
    
    /**
     * Get the covid_form_submission associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function covid_form_submission()
    {
        return $this->hasOne(Covid19Data::class)->latest('created_at');
    }
}
