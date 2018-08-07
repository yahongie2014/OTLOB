<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_name', 'email', 'password','phone','pic','v_code','area_id','verified',
        'login_by','device_type','token','is_vendor','is_admin','address','access_token',
        'country','currency_id','fees','type','cat_id','communication','nation_id','is_privillage',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'v_code'
    ];
    public function Feeds(){
        return $this->hasMany("App/Feeds");
    }
    public function Order(){

        return $this->hasMany("App/Order");
    }
    public function Notification(){

        return $this->hasMany("App/Notification");
    }
    public function Payment(){

        return $this->hasMany("App/Payment");
    }

    public function Products(){
        return $this->hasMany('App\Product');
    }
    public function Bookmark(){

        return $this->hasMany("App/Bookmark");
    }

    public function Webnotifications(){

        return $this->hasMany("App/WebNotification");
    }

    public function cart(){
        return $this->hasMany("App\Cart");
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();  // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
             ]
        ];
    }

    public function categories()
    {
        return $this->BelongsToMany('App\Category', 'user_category', 'cat_id', 'user_id');
    }

    public function rate()
    {
        return $this->hasManyThrough(
            'App\Feeds', 'App\Product',
            'user_id', 'prod_id', 'id'
        )->selectRaw('ROUND(avg(rate),1) AS avg , count(*) as counter');
    }
    public function role(){

        return $this->hasMany('App\Roles');
    }
}