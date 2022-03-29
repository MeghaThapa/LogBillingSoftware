<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use DataTables;
use App\Models\PurchaseItem;
use App\Models\Stock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PurchaseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {        
       $purchase=DB::table('purchases')
       ->where('purchases.id',$id)
       ->join('suppliers','suppliers.id','=','purchases.supplier_id')
       ->select('purchases.id','purchases.invoice_number','purchases.transaction_date','purchases.bill_date','purchases.bill_no','suppliers.name','suppliers.address'  )
       ->get()
       ->first();
    //    return $purchase;
        $product=DB::table('products')
        ->where('status','ACTIVE')
       ->select(['id','name'])
       ->get();
       $purchaseItem=DB::table('purchase_items')
       ->where('purchase_items.purchase_id',$id)
       ->join('products','products.id','=','purchase_items.product_id' )
       ->select('purchase_items.id','purchase_items.quantity','purchase_items.rate','purchase_items.amount','purchase_items.discount_percent','purchase_items.discount_amount','products.name','products.unit')
       ->get();

        return view('purchaseItem.index',['purchase'=>$purchase,'product'=>$product,'purchaseItem'=>$purchaseItem]);
    }
    public function purchaseBill($id){
        $purchase=DB::table('purchases')
        ->where('purchases.id',$id)
        ->join('suppliers','suppliers.id','=','purchases.supplier_id')
        ->select('purchases.id','purchases.total_amount','purchases.discount_amount','purchases.net_amount','purchases.invoice_number','purchases.transaction_date','purchases.bill_date','purchases.bill_no','suppliers.name','suppliers.address'  )
        ->get()
        ->first();
        
        $purchaseItem=DB::table('purchase_items')
        ->where('purchase_items.purchase_id',$id)
        ->join('products','products.id','=','purchase_items.product_id' )
        ->select('purchase_items.id','purchase_items.quantity','purchase_items.rate','purchase_items.amount','purchase_items.discount_percent','purchase_items.discount_amount','products.name','products.unit')
        ->get();
        
        $setting=DB::table('settings')
        ->get(['name','address','contact_number','email'])
        ->first();
        
        return view('purchaseItem.purchaseBill',['purchase'=>$purchase,'purchaseItem'=>$purchaseItem,'setting'=>$setting]);
    }
    public function editData($id){
        $data=DB::table('purchase_items')
        ->where('purchase_items.id',$id)
        ->join('products','products.id','=','purchase_items.product_id' )
         ->get(['products.id as prod_id','products.name','purchase_items.id','purchase_items.quantity','purchase_items.rate','purchase_items.discount_percent','purchase_items.discount_amount'])
        ->first();
        return $data;

    }
    public function updateSave (Request $request){
        $value=PurchaseItem::find($request->id);
        $value->store($request,$value->purchase_id,$value);

       return back();
    }
    public function productItemUpdate($id){

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       $purchaseItem=PurchaseItem::find($id)->Delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseItem $purchaseItem)
    {
        //
    }
    
    public function saveData(Request $request, $id){
        
       $purchaseItem= new PurchaseItem();
        $purchaseItem->store($request,$id,$purchaseItem);
        $stock= new Stock();
        $stock->batch_number=time();
        $stock->quantity=$purchaseItem->quantity;
        $stock->cp=$purchaseItem->amount;
        $stock->sp=$request->spA;
        $stock->purchase_items_id=$purchaseItem->id;
        $stock->save();
       return back();
    }
   
    public function calculation(){
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseItem $purchaseItem)
    {
        //
    }
}
