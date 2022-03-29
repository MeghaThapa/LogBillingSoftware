<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\Supplier;



class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $supplierData= Supplier::with('creator','editor')
        // ->where('id',2)
        // ->get(['name','contact','address','contact','pan_no','vat_no','remark','created_by','updated_by'])
        // ->first(); 
        // return  purchase_invoice();
        
        return view('supplier.index');
    }
    public function indexAjax(){
        $values= DB::table('suppliers')->where('deleted_by',null)->get(['id','name','address','contact','pan_no','vat_no']);
        //$value = Customer::get(['id','name','email','address','contact_no_1','contact_no_2','remark']);
        
       return DataTables::of($values)
         ->addIndexColumn()
         ->addColumn('action',function($data){
             $button = '
             <a href="/supplier/'.$data->id.'/edit">
                 <i class="fas fa-user-edit fa-lg"></i>
             </a>
             &#160
             <a class="showSupplierModel" id="'.$data->id.'">
             <i class="fas fa-eye fa-lg "></i>
         </a> 
         &#160
             <a class="dltSupplier" id="'.$data->id.'">
                 <i class="fas fa-trash-alt fa-lg "></i>
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');
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
            'contact'=>'required|max: 10|min:10',
            'pan_no'=>'max: 9|min:9',
            'vat_no'=>'max:9|min:9'
        ]);
        $supplier= new Supplier;
        $supplier->name= $request->name;
        $supplier->address= $request->address;
        $supplier->contact= $request->contact;
        $supplier->pan_no=empty($request->pan_no)?"empty":$request->pan_no;
        $supplier->vat_no=empty($request->pan_no)?"empty":$request->pan_no;
        $supplier->remark=empty($request->remark)? "empty":$request->remark;
        $supplier->save();
        return redirect()->route('supplier.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modelData($id){
        $supplierData= Supplier::with('creator','editor')
        ->where('id',$id)
        ->get(['name','contact','address','contact','pan_no','vat_no','remark','created_by','updated_by'])
        ->first();        
        return $supplierData;
    }
    public function trash(){
        return view('supplier.trash');
    }
    public function restoreSupplier($id){
        $recoveryData=Supplier::onlyTrashed()->find($id);
        $recoveryData->status = 'active';
        $recoveryData->restore();
    }

    public function trashDelete($id){
        $trashDelete=Supplier::onlyTrashed()->find($id)->forceDelete();  
      }
      
    public function trashData(){
        $values= DB::table('suppliers')
        ->whereNotNull('deleted_by')
        ->get(['id','name','contact','address','pan_no','vat_no','remark']);
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
             <a class="dltSupplier" id="'.$data->id.'">
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
   
    public function edit($id)
    {
        
        $supplierId=Supplier::get(['id','name','address','contact','pan_no','vat_no','remark'])->find($id);
        // dd($supplierId);
        return view('supplier.edit',['supplier'=>$supplierId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' =>'required|max: 255',
            'address'=>'required|max: 255',
            'contact'=>'required|max: 10|min:10',
            'pan_no'=>'max: 9|min:9',
            'vat_no'=>'max:9|min:9'
        ]);
       $supplierUpdate= Supplier::get(['id','name','contact','address','pan_no','vat_no','remark'])->find($id);
       $supplierUpdate->name=$request->name;
       $supplierUpdate->contact=$request->contact;
       $supplierUpdate->address=$request->address;
       $supplierUpdate->pan_no=$request->pan_no;
       $supplierUpdate->vat_no=$request->vat_no;
       $supplierUpdate->remark=$request->remark;
       $supplierUpdate->save();
       return redirect()-> route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier= Supplier::find($id);
        $supplier->status='inactive';
        $supplier->delete();
    }
}
