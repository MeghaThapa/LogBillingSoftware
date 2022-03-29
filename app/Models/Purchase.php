<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    protected $datas = ['deleted_at']; //for softDelete
    protected $fillables =
    [
       'invoice_number',
       'fiscal_year',
       'transaction_date',
       'bill_date',
       'bill_no',
       'total_amount',
       'discount_amount',
       'Vat_amount',
       'extra_charges',
       'rounding',
       'net_amount',
       'purchase_type',
       'remark',
       'supplier_id',
       'status',
       

   ];
   public function storeData( $purchase, $request){
   
    $purchase->invoice_number= purchase_invoice();
    $purchase->transaction_date=$request->transaction_date;
  
    $purchase->supplier_id=$request->supplier_id;
    $purchase->bill_no=$request->bill_no;
    $purchase->bill_date=$request->bill_date;
    $purchase->save();

   } 
   public function supplier(){
       return $this->belongsTo(Supplier::class);
   }
   public function purchaseItem(){
    return $this->hasMany(PurchaseItem::class,'purchase_id')->select('id','quantity','rate','amount','discount_percent','discount_amount','product_id','purchase_id');
}
   
}
