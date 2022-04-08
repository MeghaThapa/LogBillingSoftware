<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceItem;
use App\Models\Stock;

use Illuminate\Support\Facades\DB;

class ServiceItemController extends Controller
{
    public function saveEdit( Request $request){
        $serviceItems=ServiceItem::find($request->id);
       
        $serviceItems->saveUpdate($serviceItems,$request,$request->id );
        return back();

    }
    public function delete($id)
    {
       $serviceItem=ServiceItem::find($id)->Delete();
    }
    
    public function editData($id){
        return ServiceItem::find($id)
        ->get(['id','product_id','stock_id','quantity'])->first();
    }
    public function serviceItemSave(){


    }
    public function save($id,Request $request){
        $serviceItem= new ServiceItem();
        $serviceItem->saveUpdate($serviceItem,$request,$id);
        return back();
    }
    public function stockData($id){
        return DB::table('stocks')
        ->join('purchase_items','purchase_items.id','=','stocks.purchase_items_id')
        ->where('purchase_items.product_id',$id)
        ->select(['stocks.id','stocks.batch_number','stocks.quantity','stocks.sp'])
        ->get();
    }
    public function completeItem($id){
        
        $orderItem = DB::table('order_items')
        ->where('order_id',$id)
        ->get();
       
        
        foreach($orderItem as $row){
            $serviceItem = DB::table('service_items')
            ->where('order_items_id', $row->id)
            ->get(['amount']);

            $stock = new Stock();
            $stock->batch_number =time();
            $stock->quantity= $row->quantity;
            $stock->cp = $serviceItem->sum('amount');
            $stock-> sp = $row->rate;
            $stock->order_items_id = $row->id;
            $stock->product_id =$row->product_id;
            $stock->save();
            
            
        }
        return redirect()->route('order.index');    
    }
}
