<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\Helper;
use App\Models\Setting;
use App\Models\order_item;
use PDF;
use DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceItem($id){
        $order=DB::table('orders')
        ->where('orders.id',$id)
        ->join('customers', 'customers.id','=','orders.customer_id')
        ->select(['orders.id','customers.name','customers.address','orders.invoice_number','orders.transaction_date','orders.delivery_date'])
        ->get()
        ->first();
        ;
        $orderItemName=DB::table('order_items')
        ->where('order_items.order_id',$id)
        ->join('products','products.id','=','order_items.product_id')
        ->select(['order_items.id','products.name'])
        ->get();
        
        $product=DB::table('stocks')
        ->join('purchase_items','purchase_items.id','=','stocks.purchase_items_id')
        ->join('products','products.id','=','purchase_items.product_id')
        ->where('products.product_type','SERVICE')
        ->select(['products.id','products.name'])
        ->get();

        $serviceItem = DB::table('service_items')
        ->where('service_items.order_id',$id)
        ->join('stocks','stocks.id','=','service_items.stock_id')
        ->join('products','products.id','=','service_items.product_id')
        ->select(['service_items.id','service_items.quantity','products.name','service_items.amount','service_items.profit_total','stocks.sp','stocks.cp'])
        ->get();
    
        
        return view('order.serviceItem',compact('order','product','serviceItem','orderItemName'));
    }
    public function index()
    {
     
        return view('order.index');
    }
    public function ajaxTableData(){
        $values= DB::table('orders')
        ->where('orders.deleted_by',null)
        ->join('customers','customers.id','=','orders.customer_id')
        ->select(['orders.id','orders.invoice_number','orders.status','customers.name','orders.transaction_date','orders.total_amount','orders.discount_amount','orders.advance_payment','orders.net_amount'])
        ->get();
        
        return DataTables::of($values)
        ->addIndexColumn()
        ->addColumn('action',function($data){
            $button='';
            if($data->status=='RUNNING'){
                $button.= '
                <a href="/OrderItem/Index/'.$data->id.'">
                <i style="color:darkblue;" class="fas fa-user-edit fa-lg"></i>
                </a>
            '; 
            }elseif($data->status=='COMPLETED'){
                $button.= '
                
                <a href="/order/printLayout/'.$data->id.'">
                <i style="color: brown" class="fa-solid fa-receipt fa-xl"></i>
               
                &#160
                '
                ;
            }
            $button.='
           
            
            <i style="color:green" class="fas fa-eye fa-lg "></i>
      
        &#160
            
                <i style="color:red" class="fas fa-trash-alt fa-lg "></i>
            
             
            '
            ;
        return $button;
        }
        )
        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $invoice=order_invoice();
        $customer=DB::table('customers')
        ->get(['id','name']);
        return view('order.create',compact('customer','invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAdvanceP (Request $request,$id)
    {
        $orderItem=order_item::where('order_id',$id)->get(['amount','discount_amount']);
        $order=Order::find($id);
        $order->advance_payment=empty($request->advance_payment)? 0:$request->advance_payment;
        $order->total_amount= $orderItem->sum('amount');     
        $order->discount_amount= $orderItem->sum('discount_amount');
        $order->net_amount=($order->total_amount) -($order->discount_amount) -($order->advance_payment);
        $order->status='COMPLETED';
        $order->save();
        
        return redirect()->route('order.orderBill',['id'=>$order->id]);
    }
    public function downloadPdf($id)
    {   
        $order=DB::table('orders')
        ->where('orders.id', $id)
        ->join('customers', 'customers.id','=','orders.customer_id')
        ->select(['orders.invoice_number','orders.net_amount','orders.total_amount','orders.discount_amount','orders.advance_payment','orders.transaction_date','customers.name','customers.address'])
        ->get()
        ->first();
        $setting =Setting::get(['id','name','address','contact_number','email'])
        ->first();
        $orderItem=DB::table('order_items')
        ->where('order_items.order_id',$id)
        ->join ('products','products.id','=','order_items.product_id')
        ->select(['products.name','products.unit','order_items.rate','order_items.amount','order_items.discount_percent','order_items.discount_amount'])
        ->get();
        $pdf = PDF::loadView('Order.orderBill',['order_items'=>$orderItem, 'setting'=>$setting,'order'=>$order]);
        $pdf->setPaper('A3', 'landscape'); 
         return $pdf->stream();
    }

    

    public function printLayout($id){
        $order=DB::table('orders')
        ->where('orders.id', $id)
        ->join('customers', 'customers.id','=','orders.customer_id')
        ->select(['orders.id','orders.invoice_number','orders.net_amount','orders.total_amount','orders.discount_amount','orders.advance_payment','orders.transaction_date','customers.name','customers.address'])
        ->get()
        ->first();
        $setting =Setting::get(['id','name','address','contact_number','email'])
        ->first();
        $orderItem=DB::table('order_items')
        ->where('order_items.order_id',$id)
        ->join ('products','products.id','=','order_items.product_id')
        ->select(['products.name','products.unit','order_items.rate','order_items.amount','order_items.discount_percent','order_items.discount_amount'])
        ->get();
        // return $order;
        return view('order.printLayout',['order_items'=>$orderItem, 'setting'=>$setting,'order'=>$order]);
    }

    public function orderBill($id){
        $order=DB::table('orders')
        ->where('orders.id', $id)
        ->join('customers', 'customers.id','=','orders.customer_id')
        ->select(['orders.invoice_number','orders.net_amount','orders.total_amount','orders.discount_amount','orders.advance_payment','orders.transaction_date','customers.name','customers.address'])
        ->get()
        ->first();
        $setting =Setting::get(['id','name','address','contact_number','email'])
        ->first();
        $orderItem=DB::table('order_items')
        ->where('order_items.order_id',$id)
        ->join ('products','products.id','=','order_items.product_id')
        ->select(['products.name','products.unit','order_items.rate','order_items.amount','order_items.discount_percent','order_items.discount_amount'])
        ->get();
        // return $order;
        return view('order.orderBill',['order_items'=>$orderItem, 'setting'=>$setting,'order'=>$order]);
    }
    public function store(Request $request)
    {
        $fiscalValue=fiscal_year();
        $fiscal="0$fiscalValue[0]/0$fiscalValue[1]";

        $order= new Order();
        $order->invoice_number=order_invoice();
        $order->fiscal_year=$fiscal;
        $order->customer_id=$request->customerId;
        $order->delivery_date=$request->delivery_date;
        $order->transaction_date=$request->bill_date;
        $order->save();
        $setting = Setting::get()->first();
        $setting->order_bill_no= $setting->order_bill_no+1;
        
        $setting->save();
        return redirect()->route('OrderItem.index',['id'=>$order->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
