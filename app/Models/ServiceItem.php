<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;
    public function saveUpdate($serviceItem,$request,$id){
        $stock=Stock::where('id',$request->stock_id)
        ->get(['id','sp','cp','quantity'])
        ->first();
        $serviceItem->product_id= $request->product_id;
        $serviceItem->quantity= $request->quantity;
        $serviceItem->amount=($stock->sp) * ($serviceItem->quantity);
        $serviceItem->profit_total= ($stock->sp - $stock->cp) * ($serviceItem->quantity);
        $serviceItem->stock_id=$request->stock_id;
        $serviceItem->order_id=$id;
        $serviceItem->order_items_id=$request->orderItem_id;
        $serviceItem->save();

        $stock->quantity=$stock->quantity - $serviceItem->quantity;
        // return $stock;

        $stock->save();


    }
}

