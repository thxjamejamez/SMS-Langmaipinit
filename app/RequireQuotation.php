<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequireQuotation extends Model
{
    protected $table = 'require_quotation';
    protected $primaryKey = 'require_no';
    public $timestamps = false;
}
