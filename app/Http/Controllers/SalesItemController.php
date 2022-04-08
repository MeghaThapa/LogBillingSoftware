<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use App\Models\Stock;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SalesItemRequest;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // return DB::table('stocks')
        // ->join('purchase_items'orderItem,'purchase_items.id','stocks.purchase_items_id')
        // ->join('order_items','order_items.id','stocks.order_items_id')
        // ->where('purchase_items.product_id',3)
        // ->orWhere('order_items.product_id',3)   
        // ->select(['stocks.id','stocks.batch_number','stocks.quantity','stocks.sp'])
        // ->get();
        

        $sales=DB::table('sales')
        ->where('sales.id', $id)
        ->join('customers','customers.id','=','sales.customer_id')
        ->select('sales.id','sales.invoice_number','customers.name','customers.address','sales.sales_date','sales.transaction_date')
        ->first();
        // return $sales;
       
        $product=DB::table('stocks')
        ->join('purchase_items','purchase_items.id','=','stocks.purchase_items_id')
        ->join('products','products.id','=','purchase_items.product_id')
        ->where('products.product_type','SALES')
        ->select(['products.id','products.name','stocks.batch_number','purchase_items.rate'])
        ->get();
   
        $salesItem=DB::table('sales_items')
        ->where('sales_items.sales_id',$id)
        ->join('products','products.id','=','sales_items.product_id')
        ->select(['sales_items.id','products.name','products.unit','sales_items.quantity','sales_items.rate','sales_items.amount','sales_items.discount_amount'])
        ->get();
        // return $salesItem;

         return view('sale.salesItem',compact('sales','product','salesItem'));
    }

    public function saveExtraCharge(Request $request,$id){

    $sales=Sale::where('id',$id)
    ->get()
    ->first();
    // return $sales;
    $sales->extra_charges=$request->extraCharge;
    $sales->status="COMPLETED";
    $sales->save();
    return redirect()->route('sale.index');

  
    }
    public function editSave(SalesItemRequest $request){
        
        $salesItem=SalesItem::where('id',$request->id)
        ->get()
        ->first();
        \DB::transaction(function()use($salesItem,$request){
         
        $stock=Stock::where('id',$request->stock_id)
         ->get()->first();
  
            
         $stock=Stock::where('id',$request->stock_id)
         ->get()->first();
         $previousQty=$stock->quantity+$salesItem->quantity;
         $stock->quantity=$previousQty - $request->quantity;
         $stock->save();
         $salesItem->storeUpdate($salesItem,$request,$salesItem->sales_id);
        });
        return back();
    }
    public function delete($id){
        \DB::transaction(function()use($id){
        $salesItem=SalesItem::find($id);
        $stock=Stock::where('id',$salesItem->stock_id)
        ->get(['id','quantity'])
        ->first();
        $stock->quantity=$stock->quantity + $salesItem->quantity;
        $stock->save();
        $salesItem->delete();
        });

    }
    public function stockData($id){
        return Stock::where('product_id',$id)
        ->get();
    }


    public function editData($id){
        
        return DB::table('sales_items')->where('id',$id)
        ->get(['id','product_id','stock_id','quantity','rate','discount_amount'])->first();
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
    public function save(SalesItemRequest $request,$id)
    {
    //  return $request;

      $saleItem= new SalesItem();
      \DB::transaction(function()use($saleItem,$request,$id){
      $saleItem->storeUpdate($saleItem,$request,$id);
      $stock=Stock::where('id',$request->stock_id)
      ->get()
      ->first();
      $stock->quantity=$stock->quantity - $request->quantity;
      $stock->save();
      });
      return back(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesItem  $salesItem
     * @return \Illuminate\Http\Response
     */
    public function show(SalesItem $salesItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesItem  $salesItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesItem $salesItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesItem  $salesItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesItem $salesItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesItem  $salesItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesItem $salesItem)
    {
        //
    }
}
