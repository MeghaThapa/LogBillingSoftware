<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

use App\Models\order_item;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $order=DB::table('orders')
        ->where('orders.id',$id)
        ->join('customers', 'customers.id','=','orders.customer_id')
        ->select(['customers.name','customers.address','orders.id','orders.invoice_number','orders.transaction_date','orders.delivery_date'])
        ->get()
        ->first();
        ;
        $product=DB::table('products')
        ->where('product_type','SALES')
        ->get(['id','name']);

        $tableData=DB::table('order_items')
        ->where('order_items.order_id',$id)
        ->join('products','products.id','=','order_items.product_id')
        ->select(['products.name','products.unit','order_items.quantity','order_items.rate','order_items.discount_percent','order_items.discount_amount','order_items.amount','order_items.id'])
        ->get();
        
        
        return view('orderItem.index',compact('order','product','tableData'));
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
    public function save(Request $request,$id)
    {
        $orderItem= new order_item();
        $orderItem->product_id=$request->product_id;
        $orderItem->order_id=$id;
        $orderItem->quantity=$request->quantity;
        $orderItem->rate=$request->rate;
        $orderItem->amount=$request->quantity * $request->rate;
        $orderItem->discount_percent=empty($request->discountP)? '0':$request->discountP;
        if(empty($request->discountP)){
            $orderItem->discount_amount= empty($request->discountA)? '0':$request->discountA;
            
            }
            else{
            $DiscountP=$orderItem->discount_percent/100 *$orderItem->amount; // converting %->Amount 
            $orderItem->discount_amount= $DiscountP;
            }
        
        $orderItem->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order_item  $order_item
     * @return \Illuminate\Http\Response
     */
    public function show(order_item $order_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order_item  $order_item
     * @return \Illuminate\Http\Response
     */
    public function edit(order_item $order_item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order_item  $order_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order_item $order_item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order_item  $order_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(order_item $order_item)
    {
        //
    }
}
