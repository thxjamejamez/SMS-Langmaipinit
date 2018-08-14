<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeInfo extends Model
{
    protected $table = 'employee_info';
    protected $primaryKey = 'emp_no';
    public $timestamps = false;
}
