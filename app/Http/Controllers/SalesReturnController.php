<?php

namespace App\Http\Controllers;

use App\Models\SalesReturn;
use App\Models\SalesItemReturn;
use App\Http\Requests\SalesReturnRequest;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
class SalesReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoices = sales_return_invoice();
        $sales=DB::table('sales')
        ->join('customers','customers.id','=','sales.customer_id')
        ->get(['sales.id','sales.sales_date','sales.invoice_number','customers.name']);
        return view('SalesReturn.create',compact('invoices','sales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesReturnRequest $request)
    {
        $customer=DB::table('sales')
        ->where('id',$request->sales_id)
        ->get('customer_id')->first();
        $salesreturn= new SalesReturn();
        \DB::transaction(function()use($salesreturn,$customer,$request){
            $fiscalValue=fiscal_year();
            $fiscal="0$fiscalValue[0]/0$fiscalValue[1]";
            
            $salesreturn->fiscal_year=$fiscal;
            $salesreturn->transaction_date=$request->transaction_date;
            $salesreturn->sales_return_date=$request->salesReturnDate;
            $salesreturn->invoice_number= sales_return_invoice();
            $salesreturn->sales_id=$request->sales_id;
            $salesreturn->customer_id= $customer->customer_id;
            $salesreturn->save();

            $setting = Setting::get()->first();
                $setting->sales_return_bill_number= $setting->sales_return_bill_number + 1;
                $setting->save();
        });
       return redirect()->route('SalesItemReturn.index',['id'=>$salesreturn->id]);
       

    }
    public function netAmountSave(Request $request,$salesReturnId){
        $salesItemReturn=SalesItemReturn::
        where('sales_returns_id',$salesReturnId)
        ->get('amount');
        
        \DB::transaction(function()use( $salesItemReturn,$request,$salesReturnId){
        
        $salesReturn=SalesReturn::where('id',$salesReturnId)
        ->get()
        ->first();
        $salesReturn->total_amount=$salesItemReturn->sum('amount');
        $salesReturn->net_amount = $salesItemReturn->sum('amount');
        $salesReturn->status="COMPLETED";
        $salesReturn->save();
        
        });
        return back();  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesReturn  $salesReturn
     * @return \Illuminate\Http\Response
     */
    public function show(SalesReturn $salesReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesReturn  $salesReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesReturn $salesReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesReturn  $salesReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesReturn $salesReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesReturn  $salesReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesReturn $salesReturn)
    {
        //
    }
}
