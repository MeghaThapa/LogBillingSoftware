<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\Setting;

use App\Http\Requests\SalesRequest;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sale.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice = sales_invoice();
        $customer= DB::table('customers')->get(['id','name']);
       

        return view('sale.create',compact('invoice','customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRequest $request)
    {
        $fiscalValue=fiscal_year();
        $fiscal="0$fiscalValue[0]/0$fiscalValue[1]";
        $sales= new Sale();
        $sales->customer_id= $request->customer_id;
        $sales->fiscal_year=$fiscal;
        $sales->transaction_date=$request->transaction_date;
        $sales->sales_date=$request->sales_date;
        $sales->invoice_number=sales_invoice();
        $sales->sales_type=$request->salesType;
        $sales->save();

        $setting = Setting::get()->first();
        $setting->sales_bill_number= $setting->sales_bill_number+1;
        $setting->save();
        return redirect()->route('SalesItem.index',['id'=>$sales->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
