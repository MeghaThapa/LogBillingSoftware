<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);    }
   public function store( $request, $id,PurchaseItem $purchaseItem){
    $purchaseItem->quantity= $request->quantity;
    $purchaseItem->rate= $request->rate;
    $purchaseItem->discount_percent= empty($request->discountP)? '0':$request->discountP;
    $purchaseItem->amount=$request->quantity * $request->rate;
    if(empty($request->discountP)){
    $purchaseItem->discount_amount= empty($request->discountA)? '0':$request->discountA;
    
    }
    else{
    $DiscountP=$purchaseItem->discount_percent/100 *$purchaseItem->amount; // converting %->Amount 
    $purchaseItem->discount_amount= $DiscountP;
    }
    $purchaseItem->product_id= $request->product_id;
    $purchaseItem->purchase_id=$id;
    $purchaseItem->save();

   }

}
