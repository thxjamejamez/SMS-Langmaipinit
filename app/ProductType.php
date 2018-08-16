<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type';
    protected $primaryKey = 'type_no';
    public $timestamps = false;
}
