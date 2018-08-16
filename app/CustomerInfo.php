<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    protected $table = 'customer_info';
    protected $primaryKey = 'cust_no';
    public $timestamps = false;
}
