<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesItem extends Model
{
    use HasFactory;

    public function storeUpdate($salesItem,$request,$id){
        $stock=DB::table('stocks')
        ->where('id',$request->stock_id)
        ->get(['cp','sp','batch_number'])
        ->first();

        $sales=DB::table('sales')
        ->where('id',$id)
        ->get('invoice_number')
        ->first();
        $salesItem->sales_id=$id;
        $salesItem->product_id=$request->product_id;
        $salesItem->quantity=$request->quantity;
        
            $salesItem->discount_amount=empty($request->discountA) ? 0:$request->discountA;
       
          if(!empty($request->rate)){
            if($stock->sp > $request->rate){
                return redirect()->back()->withFail(['Rate should not be smaller then sp.']);
            }
            $salesItem->rate=$request->rate -$salesItem->discount_amount;
            $salesItem->amount=$salesItem->quantity * $salesItem->rate;
        }else{
            $salesItem->rate=$stock->sp - $salesItem->discount_amount;
            $salesItem->amount=$salesItem->quantity * $salesItem->rate;
        }
        
        $salesItem->batch_number=$stock->batch_number;
        $salesItem->invoice_number=$sales->invoice_number;
        $salesItem->stock_id= $request->stock_id;
        // $salesItem->sales_id=$request->sales_id;
        $salesItem->profit_per_item= $salesItem->rate - $stock->cp;
        $salesItem->profit_total =$salesItem->profit_per_item * $salesItem->quantity;
        $salesItem->save();

    }
}
