<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class SaleSummaryController extends Controller
{
    function index () {
        $cedit = $this->canAccessPage($this->user->id, 59);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        return view ('report.summary');
    }

    function getdata () {
        $sub = '(SELECT IFNULL(SUM(price * qty), 0) FROM order_detail WHERE order_detail.order_no = order.order_no) AS sum';
        $order = DB::table('order')
            ->whereIn('order.status', [2,3,4,5])
            ->select('order.order_no'
                    ,'order.order_date'
                    ,DB::raw($sub)
                    )
            ->get();
        return response()->json(['order' => $order]);
    }

    function getsalary () {
        $salary = DB::table('users')
            ->join('user_permissions','user_permissions.user_id','=','users.id')
            ->join('group_permissions','user_permissions.permission_id','=','group_permissions.id')
            ->join('employee_info', 'users.id', '=', 'employee_info.users_id')
            ->join('l_title', 'employee_info.title_id', '=', 'l_title.title_id')
            ->select([  'users.id',
                        'users.username', 
                        'users.email',
                        'permission_id',
                        'permission_name',
                        'l_title.title_name',
                        'employee_info.emp_no',
                        'employee_info.first_name',
                        'employee_info.last_name',
                        'employee_info.salary',
                        'employee_info.start_date'
            ])
            ->get();
        return response()->json(['salary' => $salary]);
    }
}
