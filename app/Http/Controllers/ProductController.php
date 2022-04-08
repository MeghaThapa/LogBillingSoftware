<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\productRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        return view('product.index');
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
    public function trash(){

        return view('product.trash');
    }
    public function restoreProduct($id){
        $recoveryData=Product::onlyTrashed()->find($id);
        $recoveryData->status = 'ACTIVE';
        $recoveryData->restore();
    }
    public function trashDelete($id){
        $trashData=Product::onlyTrashed()->find($id)->forceDelete();
    }
    public function trashData(){
        $values= DB::table('products')
        ->whereNotNull('deleted_by')
        ->get(['id','name','unit','status','product_type','remark']);

        return DataTables::of($values)
        ->addIndexColumn()
        ->addColumn('actions',function($data){
            $button = '
             <a class="restoreProduct" id="'.$data->id.'">
            <i class="fas fa-sync-alt"></i>
            </a>
            &#160
            &#160
            &#160
            <a class="dltProduct" id="'.$data->id.'">
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
    public function store(ProductRequest $request)
    {
        $product= new Product();
       $product->name= $request->name;
       $product->unit= $request->unit;
       $product->product_type= $request->pType;
       $product->status=$request->status;
       $product->remark= empty($request->remark)? null:$request->remark;
       $product->save();
       return redirect()-> route('product.index');
    }
    public function productValueE($id){
        $values=DB::table('products')
        ->where('status','ACTIVE')
        ->where('id',$id)
        ->get(['id','name','status','unit','product_type','remark'])
        ->first();
      return $values;

    }
    public function viewData($id){
        $value=Product::with('creator','editor')
        ->where('status','ACTIVE')
        ->where('id',$id)
        ->get(['id','name','status','unit','product_type','remark','created_by','updated_by'])
        ->first();
      return $value;

    }

    public function indexAjax(){
        $values= DB::table('products')->where('status','ACTIVE')->get(['id','name','status','unit','product_type','remark']);
        
       return DataTables::of($values)
         ->addIndexColumn()
         ->addColumn('action',function($data){
             $button = '
             <a class="showProductModel" id="'.$data->id.'">
                 <i class="fas fa-user-edit fa-lg"></i>
             </a>
             &#160
             <a class="showProductDetails" id="'.$data->id.'">
             <i class="fas fa-eye fa-lg "></i>
         </a> 
         &#160
             <a class="dltProduct" id="'.$data->id.'">
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
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function productUpdate(ProductRequest $request)
    {
        $value=Product::find($request->id);
        $value->name=$request->name;
        $value->unit=$request->unit;
        $value->product_type=$request->pType;
        $value->status=empty($request->remark)? null:$request->remark;
        $value->save();
        return back();
      
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
   
    public function destroy($id)
    {
        $product= Product::find($id);
        $product->status='inactive';
        $product->delete();
    }
}
