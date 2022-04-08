<?php

namespace App\Http\Controllers;

use App\Models\SalesItemReturn;
use Illuminate\Support\Facades\DB;
use App\Models\SalesItem;
use App\Models\Stock;

use Illuminate\Http\Request;

class SalesItemReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
        $salesreturn=DB::table('sales_returns')
        ->where('sales_returns.id',$id)
        ->join('customers','customers.id','=','sales_returns.customer_id')
        ->get(['customers.name','sales_returns.id','customers.address','sales_returns.sales_id','sales_returns.invoice_number','sales_returns.sales_return_date','sales_returns.transaction_date'])
        ->first();
        
        $productDetails=DB::table('sales_items')
        ->where('sales_items.sales_id',$salesreturn->sales_id)
        ->whereNull('sales_items.sales_return_id')
        ->join('products','products.id','=','sales_items.product_id')
        ->get(['products.name','sales_items.quantity','sales_items.rate','sales_items.id'])
        ;
        $salesItemReturn=DB::table('sales_item_returns')
        ->where('sales_returns_id',$id)
        ->join('products','products.id','=','sales_item_returns.product_id')
        ->get(['sales_item_returns.id','sales_item_returns.quantity','products.unit','products.name','sales_item_returns.rate','sales_item_returns.amount']);
      
        // return $productDetails;
        return view('salesItemReturn.index',compact('salesreturn','productDetails','salesItemReturn'));
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
    public function save(Request $request,$sales_return_id)
    {
        $request->validate(
            [
                'salesItem_id'=>'required'
            ]
        );
        \DB::transaction(function()use($sales_return_id,$request){
        $salesItem=SalesItem::where('id',$request->salesItem_id)
        ->get(['id','stock_id','sales_return_id','rate','product_id'])
        ->first();
        $stock=Stock::where('id',$salesItem->stock_id)
        ->get(['id','quantity'])
        ->first();
        $quantity=0;
        if(empty($request->quantity)){
            $quantity=$stock->quantity;
        }else{
            $quantity=$request->quantity;
        }
        if($quantity>$stock->quantity){
            return redirect()->back()->withFail(['Return quantity should be less or equal to sales item quantity.']);
        }
        $stock->quantity=$stock->quantity +$quantity;
        $stock->save();
        $salesItem->sales_return_id=$sales_return_id;
        $salesItem->sales_order_type="RETURN";
        $salesItem->save();

        $salesItemReturn=new SalesItemReturn();
        $salesItemReturn->product_id=$salesItem->product_id;
        $salesItemReturn->sales_returns_id =$sales_return_id;
        $salesItemReturn->rate=$salesItem->rate;
        $salesItemReturn->quantity=$quantity;
        $salesItemReturn->amount=$salesItemReturn->rate*$salesItemReturn->quantity;
        $salesItemReturn->stock_id=$stock->id;
        $salesItemReturn->sales_items_id=$salesItem->id;
        $salesItemReturn->save();
        
    });
    return back();
    }
    public function delete($id){
        \DB::transaction(function()use($id){

            $salesItemReturn=SalesItemReturn::find($id)
            ->get()
            ->first();
            $sales_item=SalesItem::where('id',$salesItemReturn->sales_items_id)
            ->get()
            ->first();
            $sales_item->sales_return_id=null;
            $sales_item->save();
            $stock=Stock::where('id',$salesItemReturn->stock_id)
            ->get()
            ->first();   
            $stock->quantity=$stock->quantity-$salesItemReturn->quantity;
            $stock->save();
            $salesItemReturn->delete();
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesItemReturn  $salesItemReturn
     * @return \Illuminate\Http\Response
     */
    public function show(SalesItemReturn $salesItemReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesItemReturn  $salesItemReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesItemReturn $salesItemReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesItemReturn  $salesItemReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesItemReturn $salesItemReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesItemReturn  $salesItemReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesItemReturn $salesItemReturn)
    {
        //
    }
}
