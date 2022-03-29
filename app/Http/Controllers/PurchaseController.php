<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Helper\Helper;
use App\Models\Setting;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseRequest;



class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

       return view('purchase.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function trash(){

    // }
    public function trash(){
        return view('Purchase.trash');
    }
    public function purchaseTrashDelete($id){
                
          if(
            DB::table('purchase_items')
            ->where('purchase_id',$id)
            ->exists()
          )  
          {
            
            return 'child';
          }
          else{
            Purchase::onlyTrashed()->find($id)->forceDelete();
          }
        
        
        
        
    }
    public function restorePurchase($id){
        Purchase::onlyTrashed()->find($id)->restore();
    }
    public function trashTableData(){
        $values= DB::table('purchases')
        ->whereNotNull('purchases.deleted_by')
        ->join('suppliers','suppliers.id','=','purchases.supplier_id')
        ->select(['purchases.id','purchases.invoice_number','purchases.transaction_date','purchases.bill_date','purchases.bill_no','purchases.net_amount','suppliers.name'])
        ->get(); 
        return DataTables::of($values)
        ->addIndexColumn()
        ->addColumn('action',function($data){
            $button='
           
            <a class="restorePurchase" id="'.$data->id.'">
            <i class="fas fa-sync-alt"></i>
            </a> 
        &#160
            <a class="dltPurchase" id="'.$data->id.'">
                <i style="color:red" class="fas fa-trash-alt fa-lg "></i>
            </a>
             
            '
            ;
        return $button;
        }
        )
        ->rawColumns(['action'])
        ->make(true);
    }
    public function create()
    {
        $value=purchase_invoice();
            
        $supplier=Supplier::all(); 
         
        return  view('purchase.create', ['supplier'=>$supplier,'value'=>$value]); 
    }
    public function modelData($id){
        $value=DB::table('purchases')
        ->where('purchases.id',$id)
        ->join('suppliers','suppliers.id','=','purchases.supplier_id')
        ->select(['suppliers.name','purchases.discount_amount','purchases.net_amount','purchases.status','purchases.bill_no','purchases.transaction_date'])
        ->get()
        ->first();
        return $value;
    }
    public function ajaxTableData(){
        $values= DB::table('purchases')
        ->where('purchases.deleted_by',null)
        ->join('suppliers','suppliers.id','=','purchases.supplier_id')
        ->select(['purchases.id','purchases.invoice_number','purchases.transaction_date','purchases.bill_date','purchases.bill_no','purchases.net_amount','purchases.status','suppliers.name'])
        ->get();
        
        return DataTables::of($values)
        ->addIndexColumn()
        ->addColumn('action',function($data){
            $button='';
            if($data->status=='RUNNING'){
                $button.= '
            <a href="/purchaseItem/index/'.$data->id.'">
                <i style="color:darkblue;" class="fas fa-user-edit fa-lg"></i>
            </a>
            &#160
            '; 
            }elseif($data->status=='COMPLETED'){
                $button.= '
                <a href="/purchaseItem/purchaseBill/'.$data->id.'">
                <i style="color: brown" class="fa-solid fa-receipt fa-xl"></i>
                </a>
                &#160
                '
                ;
            }
            $button.='
           
            <a class="showPurchaseDetails" id="'.$data->id.'">
            <i style="color:green" class="fas fa-eye fa-lg "></i>
        </a> 
        &#160
            <a class="dltPurchase" id="'.$data->id.'">
                <i style="color:red" class="fas fa-trash-alt fa-lg "></i>
            </a>
             
            '
            ;
        return $button;
        }
        )
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request,$id){
            
        $value=Purchase::withSum('purchaseItem','amount')
        ->withSum('purchaseItem','discount_amount')
        ->find($id);
        

            $value->vat_amount=empty($request->vat)? 0:$request->vat;
            $value->extra_charges=empty($request->extraCharge)? 0:$request->extraCharge;
            $value->total_amount=empty($value->purchase_item_sum_amount)? 0 : $value->purchase_item_sum_amount;
            $value->discount_amount=empty($value->purchase_item_sum_discount_amount)? 0: $value->purchase_item_sum_discount_amount;
            $value->net_amount=($value->total_amount+$value->extra_charges+$value->vat_amount)- ($value->discount_amount);
            $value->status="COMPLETED";
            $value->save();
            
        return redirect()->route('purchaseItem.purchaseBill',['id'=>$value->id]);
    }
    public function store(PurchaseRequest $request)
    {
       
        // return $request;
        $fiscalValue=fiscal_year();
        $fiscal="0$fiscalValue[0]/0$fiscalValue[1]";
        $purchase= new Purchase();
        $purchase->fiscal_year=$fiscal;
        $purchase->storeData($purchase,$request);

        $setting = Setting::get()->first();

        $setting->purchase_bill_number= $setting->purchase_bill_number+1;
        
        $setting->save();
        return redirect()->route('purchaseItem.index',['id'=>$purchase->id]);
     

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
    }
}
