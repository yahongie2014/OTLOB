<?php

namespace App;
use App\Product;
use App\BankAccount;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'daily_report';

    protected $fillable = array('date','all_users','providers','all_products', 'waiting_products' , 'active_products' , 'deactivated_products' , 'all_orders' , 'completed_orders' , 'rejected_orders' , 'preparing_orders' , 'waiting_orders' , 'feed_back');



}
