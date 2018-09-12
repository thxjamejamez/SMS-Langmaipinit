<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class WorkScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lworksts = DB::table('l_order_sts_for_work')->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
        $worksts = $lworksts->id;
        $workstses = DB::table('l_order_sts_for_work')
            ->where('active', 1)
            ->get();
        return view('workschedule.index', compact('worksts', 'workstses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function getData() {
        $order = DB::table('order')
            // ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->join('l_order_sts_for_work', 'order.status_forwork', '=', 'l_order_sts_for_work.id')
            ->where('order.status_forwork', '>', 0)
            ->get();

        return response()->json(["data"=>$order]);
    }
}
