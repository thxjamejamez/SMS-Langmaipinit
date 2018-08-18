<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductForCust extends Model
{
    protected $table = 'product_for_cust';
    protected $primaryKey = 'product_cust_no';
    public $timestamps = false;
}
