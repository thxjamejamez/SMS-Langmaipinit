<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\CustomerInfo,
    \App\Invoice,
    \App\InvoiceDetail,
    DB;

class CreInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cedit = $this->canAccessPage($this->user->id, 55);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        return view('invoice.create.index');
    }

    function userhaveInvoice () {
        $orderdetail =  DB::table('invoice_detail')->pluck('invoice_detail.order_no');
        $userforIV = DB::table('order')
        ->join('customer_info', 'order.users_id', '=', 'customer_info.users_id')
        ->when($orderdetail, function ($userIv) use ($orderdetail){
                $userIv->whereNotIn('order.order_no', $orderdetail);
        })
        ->where('order.status', 5)
        ->select('customer_info.users_id'
                ,'customer_info.first_name'
                ,'customer_info.last_name'
                ,'customer_info.company_name'
                )
        ->groupBy('order.users_id')
        ->get();
        return [ 'data' => $userforIV ];
    }

    function createIV($user) {
        $orderdetail =  DB::table('invoice_detail')->pluck('invoice_detail.order_no');
        $order = DB::table('order')
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->where('order.users_id', $user)
            ->where('order.status', 5)
            ->when($orderdetail, function ($userIv) use ($orderdetail){
                $userIv->whereNotIn('order.order_no', $orderdetail);
            })
            ->get();

        return view('invoice.create.createIV', compact('order'));

    }

    function saveIV (Request $request) {
        $due_date = '';
        $maxinvnumber = Invoice::select(DB::raw('MAX(invoice_number) as max'))->first();
        $max = $maxinvnumber->max + 1;

        $chkcredit = CustomerInfo::where('users_id', $request['users_id'])->first();
        if(isset($chkcredit->company_credit)){
            $due_date = date('Y-m-d', strtotime($request['invoice_date'] . "+" .$chkcredit->company_credit." days"));
        }else{
            $due_date = date('Y-m-d', strtotime($request['invoice_date']));
        }

        $IVEloquent = new Invoice ();
        $IVEloquent->invoice_date = date('Y-m-d', strtotime($request['invoice_date']));
        $IVEloquent->invoice_number = $max;
        $IVEloquent->due_date = $due_date;
        $IVEloquent->invoice_sts = 1;
        $IVEloquent->users_id = $request['users_id'];
        $IVEloquent->save();

        foreach($request['choose_order'] as $a){
            $IVDEloquent = new InvoiceDetail ();
            $IVDEloquent->invoice_no = $IVEloquent->invoice_no;
            $IVDEloquent->order_no = $a;
            $IVDEloquent->save();
        }
        return 'success';
    }

    function admininvoice (){
        $cedit = $this->canAccessPage($this->user->id, 56);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        $invlist = Invoice::join('customer_info', 'invoice.users_id', '=', 'customer_info.users_id')
            ->join('l_invoice_sts', 'invoice.invoice_sts', '=', 'l_invoice_sts.id')
            ->get();
        return view('invoice.admin.index', compact('invlist'));
    }

    function invoicedetail($id) {
        $invinfo = Invoice::join('customer_info', 'invoice.users_id', '=', 'customer_info.users_id')
            ->leftjoin('l_city as citycus', 'customer_info.district_id', '=', 'citycus.city_id')
            ->leftjoin('l_province as procus', 'customer_info.province_id', '=', 'procus.province_id')
            ->leftjoin('l_city as citycom', 'customer_info.company_district', '=', 'citycom.city_id')
            ->leftjoin('l_province as procom', 'customer_info.company_province', '=', 'procom.province_id')
            ->join('l_title', 'customer_info.title_id', '=' ,'l_title.title_id')
            ->leftjoin('users', 'customer_info.users_id', '=', 'users.id')
            ->join('l_invoice_sts', 'invoice.invoice_sts', '=', 'l_invoice_sts.id')
            ->where('invoice_no', $id)
            ->select('*'
                    ,'citycus.city_name as city_cus'
                    ,'procus.province_name as pro_cus'
                    ,'citycom.city_name as city_com'
                    ,'procom.province_name as pro_com'
                    )
            ->first();

        $sub = '(SELECT IFNULL(SUM(price * qty), 0) FROM order_detail WHERE order_detail.order_no = order.order_no) AS sum';
        $invdetail = InvoiceDetail::join('order', 'invoice_detail.order_no', '=', 'order.order_no')
            ->where('invoice_detail.invoice_no', $id)
            ->select('order.order_no'
                    ,'order.send_date'
                    ,DB::raw($sub)
                    )
            ->get();
        return view('invoice.detail', compact('invinfo', 'invdetail'));
    }

    function printinvoicedetail ($id) {
        $invinfo = Invoice::join('customer_info', 'invoice.users_id', '=', 'customer_info.users_id')
            ->leftjoin('l_city as citycus', 'customer_info.district_id', '=', 'citycus.city_id')
            ->leftjoin('l_province as procus', 'customer_info.province_id', '=', 'procus.province_id')
            ->leftjoin('l_city as citycom', 'customer_info.company_district', '=', 'citycom.city_id')
            ->leftjoin('l_province as procom', 'customer_info.company_province', '=', 'procom.province_id')
            ->leftjoin('users', 'customer_info.users_id', '=', 'users.id')
            ->join('l_invoice_sts', 'invoice.invoice_sts', '=', 'l_invoice_sts.id')
            ->where('invoice_no', $id)
            ->select('*'
                    ,'citycus.city_name as city_cus'
                    ,'procus.province_name as pro_cus'
                    ,'citycom.city_name as city_com'
                    ,'procom.province_name as pro_com'
                    )
            ->first();

        $sub = '(SELECT SUM(price * qty) FROM order_detail WHERE order_detail.order_no = order.order_no) AS sum';
        $invdetail = InvoiceDetail::join('order', 'invoice_detail.order_no', '=', 'order.order_no')
            ->where('invoice_detail.invoice_no', $id)
            ->select('order.order_no'
                    ,'order.send_date'
                    ,DB::raw($sub)
                    )
            ->get();
        return view('invoice.invoice-print', compact('invinfo', 'invdetail'));
    }

    function myinvoiceindex () {
        $cedit = $this->canAccessPage($this->user->id, 57);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');

        $linvsts = DB::table('l_invoice_sts')->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
        $invsts = $linvsts->id;
        $invstses = DB::table('l_invoice_sts')
            ->get();
        return view('invoice.myinvoice.index', compact('invsts', 'invstses'));
    }

    function getmyinvoice () {
        $user = \Auth::user();
        $invlist = Invoice::join('customer_info', 'invoice.users_id', '=', 'customer_info.users_id')
            ->join('l_invoice_sts', 'invoice.invoice_sts', '=', 'l_invoice_sts.id')
            ->where('invoice.users_id', $user->id)
            ->get();

            return response()->json(['data' => $invlist]);
    }

    function updateslip(Request $request) {
        $inv = Invoice::find($request['invoice_no']);
        if ($request['typeupload'] == 1){
            if($request->file('file')){
                $image = $request->file('file');
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('/slip_file'), $fileName);
            }
            if(isset($fileName)){$inv->pay_file = $fileName;}
        }else if ($request['typeupload'] == 2) {
            $inv->money = $request['textmoney'];
        }
        $inv->pay_datetime = $request['pay_datetime'];
        $inv->invoice_sts = 2;
        $inv->save();

        return 'success';
    }

    function getdetailpay ($id) {
        $detail = Invoice::find($id);
        return response()->json($detail);
    }

    function updatepay($invoice_no, $sts) {
        $inv = Invoice::find($invoice_no);
        if($sts == 4) {
            if(!isset($inv->pay_file)){
                unlink('slip_file/'.$inv->pay_file);
            }
            $inv->invoice_sts = $sts;
            $inv->pay_file = '';
            $inv->money = '';
            $inv->pay_datetime = '';
            $inv->save();
            
        }else {
            $inv->received_date = DB::raw('NOW()');
            $inv->invoice_sts = $sts;
            $inv->save();
        }
        return 'success';
    }
}
