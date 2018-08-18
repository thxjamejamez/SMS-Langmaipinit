<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\RequireQuotation,
    DB;

class RequireQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('quotation.index');            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('quotation.require');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        // $this->validate($request, [
        //     'requofile' => 'mimes:jpeg,png,JPG,gif,svg|max:8000',
        // ]);
        $image = $request->file('requofile');
        $fileName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('/file_quotation'), $fileName);

        $reQuoEloquent = new RequireQuotation();
        $reQuoEloquent->require_detail = $request['re_detail'];
        $reQuoEloquent->file = $fileName;
        $reQuoEloquent->cust_no = $user->id;
        $reQuoEloquent->sts_id = 1;
        $reQuoEloquent->save();

        return back()->with('success', 'Uploaded')->with('path', $fileName);
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

    function requotationlist () {
        $user = \Auth::user();
        $data = DB::Table('require_quotation')
            ->join('l_require_sts', 'require_quotation.sts_id', '=', 'l_require_sts.id')
            ->where('cust_no', $user->id)
            ->get();
        return response()->json(["data"=>$data]);
    }
}
