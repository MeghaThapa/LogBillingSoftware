<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|max: 255',
            'address'=>'required|max: 255',
            'contact_no_1'=>'required|max: 10|min:10',
        ]);
        $customer= new Customer;
        $customer->name= $request->name;
        $customer->email= $request->email;
        $customer->address= $request->address;
        $customer->contact_no_1= $request->contact_no_1;
        $customer->contact_no_2=empty($request->contact_no_2)?"empty":$request->contact_no_2 ;
        $customer->remark=empty($request->remark)? "empty":$request->remark;
        $customer->save();
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data=DB::table('customers')->select('id','name','address','email','contact_no_1','contact_no_2','remark')->find($id); 
       return view('customer.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required|max: 255',
            'address'=>'required|max: 255',
            'contact_no_1'=>'required|max: 10|min:10',
            'contact_no_2'=>'max:10|min:10'
        ]);
        $customer=Customer::find($id);
        $customer->name=$request->name;
        $customer->email=$request->email;
        $customer->contact_no_1= $request->contact_no_1;
        $customer->contact_no_2= $request->contact_no_2;
        $customer->remark= $request->remark;
        $customer->save();
        return redirect()-> route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer= Customer::find($id);
        $customer->status='inactive';
        $customer->delete();
    }
    public function modelData($id){
        $customer= Customer::find($id)->get(['name','email','address','contact_no_1','contact_no_2','remark'])->first();
        return $customer;
    }
    public function trash(){
        //return DB::table('customers')->whereNotNull('deleted_by')->get(['id','name','email','address','contact_no_1','contact_no_2','remark']);
       return view('Customer.trash');
    }
    public function indexAjax()
    {
        $values= DB::table('customers')->where('deleted_by',null)->get(['id','name','email','address','contact_no_1','contact_no_2','remark']);
       //$value = Customer::get(['id','name','email','address','contact_no_1','contact_no_2','remark']);
       
      return DataTables::of($values)
        ->addIndexColumn()
        ->addColumn('action',function($data){
            $button = '
            <a href="/customer/'.$data->id.'/edit">
                <i class="fas fa-user-edit fa-lg"></i>
            </a>
            <a class="dltCustomer" id="'.$data->id.'">
                <i class="fas fa-trash-alt fa-lg "></i>
            </a>
            <a class="showCustomerModel" id="'.$data->id.'">
            <i class="fas fa-eye fa-lg "></i>
        </a>    
            '
            ;
        return $button;
        }
        )
        ->rawColumns(['action'])
        ->make(true);
        
    }
    public function trashRecovery($id){
        $recoveryData=Customer::onlyTrashed()->find($id);
        $recoveryData->status = 'active';
        $recoveryData->restore();
    }
    public function trashDelete($id){
        $trashDelete=Customer::onlyTrashed()->find($id)->forceDelete();

    }
    public function trashData(){
        $values= DB::table('customers')->whereNotNull('deleted_by')->get(['id','name','email','address','contact_no_1','contact_no_2','remark']);
        //$value = Customer::get(['id','name','email','address','contact_no_1','contact_no_2','remark']);
        
       return DataTables::of($values)
         ->addIndexColumn()
         ->addColumn('actions',function($data){
             $button = '
             <a class="restore" id="'.$data->id.'">
             <i class="fas fa-sync-alt"></i>
             </a>
             &#160
             &#160
             &#160
             <a class="dltCustomer" id="'.$data->id.'">
                 <i class="fas fa-trash-alt fa-lg "></i>
             </a>
              
             '
             ;
         return $button;
         }
         )
         ->rawColumns(['actions'])
         ->make(true);
    }
}
