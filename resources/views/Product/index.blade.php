@extends('layouts.app')
@section('content')
<div class="container">
<div class="card card-body shadow mb-5">
    <center>
        <h1>PRODUCT DASHBOARD</h1>
    </center>
</div>
@if($errors->any())
<div class="alert alert-danger" role="alert">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</div>
@endif

    <div class="row mb-2">
       <div class="col-md-9"></div>
       <div class="col-md-1">
           <a href=" {{ route('product.trash') }}" >
           
           <div class="btn btn-danger">Trash</div>
        </a>
       </div>
       <div class="col-md-2">
        <a href="" class="createProduct" data-bs-toggle="modal" data-bs-target="#addProduct">
           
           <div class ="btn btn-success"> ADD PRODUCT</div>
        </a>
   </div>
    </div>

<div class="row">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
             Product DataTable 
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered productTable" width="100%" >
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Item Type</th>
                        <th>Status</th>
                        <th>Remark</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div> 
{{-- crerate modal --}}
<div class="modal fade" id="addProduct"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            
          <h5 class="modal-title" id="exampleModalLabel">
         Add Product
        </h5>
    
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('product.store') }}" method="POST">
            @csrf
        <div class="modal-body">

          <div class="row">
           
              <div class="row m-2">
                  <div class="col-md-4 ">
                    <label for="s" class="form-label fw-bold">Item Type</label>
                 </div>
                <div class="col-md-4 ">
                    <input type="radio" name="pType" value="SALES" id="s"checked>
                    <label >Sales</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="pType" value="SERVICE" id="s">
                    <label >Service</label>
                </div>
            
           
            </div>
            
            
             <div class="row m-2">
                 <div class="col-md-4">
                    <label for="nameV" class="form-label fw-bold">Name</label>
                 </div>
                 <div class="col-md-8">
                     <input type="text"  name="name" id="nameV" class="form-control mb-2 ">
                 </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
               <label  class="form-label fw-bold">Status</label>
            </div>
            <div class="col-md-8">
                <select name="status" id="statusV" class="form-control select2" required>
                    <option value="" selected disabled>---status---</option>
                    
                          <option value="ACTIVE">Active</option>
                          <option value="INACTIVE">Inactive</option>

                  </select>
            </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Unit</label>
                </div>
                <div class="col-md-8">
                    <select name="unit" id="units" class="form-control select2" required>
                        <option value="" selected disabled>---Unit---</option>
                        <option value="KB">K.B</option>
                        <option value="piece">Piece</option>
                        <option value="squareFoot">Square Foot</option>
                      </select>
                </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
                    <label for="remarkV"  class="form-label fw-bold">Remark</label>
                </div>
                <div class="col-md-8">
                    <input type="text"  name="remark" id="remarkV" class="form-control mb-2 ">

                </div>
            </div>
          </div>
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a href="{{ route('product.store') }}">
          <button type="submit" class="btn btn-primary">Save</button>
        </a>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
{{-- edit modal --}}
<div class="modal fade" id="editProduct"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            
          <h5 class="modal-title" id="exampleModalLabel">
         Edit Product
        </h5>
    
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('product.productUpdate') }}" method="POST">
            @csrf
           
        <div class="modal-body">
            <input type="text" name="id" id="Pid" hidden >
          <div class="row">
           
              <div class="row m-2">
                  <div class="col-md-4 ">
                    <label class="form-label fw-bold">Item Type</label>
                 </div>
                <div class="col-md-4 ">
                    <input type="radio" name="pType" value="SALES" id="sls">
                    <label >Sales</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="pType" value="SERVICE" id="srv">
                    <label >Service</label>
                </div>
            
           
            </div>
            
            
             <div class="row m-2">
                 <div class="col-md-4">
                    <label for="nameV" class="form-label fw-bold">Name</label>
                 </div>
                 <div class="col-md-8">
                     <input type="text"  name="name" id="Pname" class="form-control mb-2 ">
                 </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
               <label class="form-label fw-bold">Status</label>
            </div>
            <div class="col-md-8">
                <select name="status" id="statusE" class="form-control select2" required>
                    {{-- <option value="" selected disabled>---status---</option> --}}
                    
                          <option value="ACTIVE">Active</option>
                          <option value="INACTIVE">Inactive</option>

                  </select>
            </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Unit</label>
                </div>
                <div class="col-md-8">
                    <select name="unit" id="unitE" class="form-control select2" required>
                        {{-- <option value="" selected disabled>---Unit---</option> --}}
                        <option value="KB">K.B</option>
                        <option value="piece">Piece</option>
                        <option value="squareFoot">Square Foot</option>
                      </select>
                </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
                    <label for="remarkV"  class="form-label fw-bold">Remark</label>
                </div>
                <div class="col-md-8">
                    <input type="text"  name="remark" id="Premark" class="form-control mb-2 ">

                </div>
            </div>
          </div>
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a href="{{ route('product.store') }}">
          <button type="submit" class="btn btn-primary">Save</button>
        </a>
        </div>
    </form>
      </div>
    </div>
  </div>
{{-- showdetail model --}}
<div class="modal fade" id="showProduct"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            
          <h5 class="modal-title fw-bold" id="exampleModalLabel" >
         Product Details
        </h5>
    
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4"><b>Name :</b></div>
                <div class="col-sm-6">
                    <p id="Nval">

                    </p>
                </div>
                <div class="col-sm-4"><b>Item Type :</b></div>
                <div class="col-sm-6">
                    <p id="PtypeVal">

                    </p>
                </div>
                <div class="col-sm-4"><b>status :</b></div>
                <div class="col-sm-6">
                    <p id="Sval">

                    </p>
                </div>
                <div class="col-sm-4"><b>Unit :</b></div>
                <div class="col-sm-6">
                    <p id="Uval">

                    </p>
                </div>
            <div class="col-sm-4"><b>Remark :</b></div>
                <div class="col-sm-6">
                    <p id="Rval">

                    </p>
                </div>
                <div class="col-sm-4"><b>Created By :</b></div>
                <div class="col-sm-6">
                    <p id="pCreatedBy">

                    </p>
                </div>
                <div class="col-sm-4"><b>Updated By :</b></div>
                <div class="col-sm-6">
                    <p id="pUpdatedBy">

                    </p>
                </div>
            </div>
    
      </div>
      </div>
    </div>
  </div>
@section('ProductIndex')
  <script>
 $(document).ready(function(){
     var table=  $('.productTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('product.indexAjax') }}",
        columns:[
        {data:'DT_RowIndex'},
        {data:'name'},
        {data:'unit'},
        {data:'product_type'},
        {data:'status'},
        {data:'remark'},
        {data:'action'}
        ]
      });

     //select2 for create model
    $("#statusV,#units").select2(
      {
        theme:'bootstrap-5',
        dropdownParent:$('#addProduct')
      }
    );  
  
//select 2 for edit model
    $("#statusE,#unitE").select2(
      {
        theme:'bootstrap-5',
        dropdownParent:$('#editProduct')
      }
    );  
   
    $('body').on('click','.showProductModel',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#editProduct').modal('toggle');   //showDetails is id of model
        $.get("/product/productValueE/"+id,function(data){
            console.log(data);
            $('#Pid').val(data.id);
            $('#Pname').val(data.name);
            $('#unitE').val(data.unit);
            $('#status').val(data.status);
            $('#Premark').val(data.remark);
            if(data.product_type== 'SALES'){
               
                $('#sls').prop('checked', true);
            }else if(data.product_type== 'SERVICE'){
            $('#srv').prop('checked', true);
        }

            
       });
             
    });
        $('body').on('click','.dltProduct',function(){
            
            var dlt_id = $(this).attr('id');
            //alert(dlt_id );
           swal({
                  title: "Are you sure?",
                  text: "Once deleted, data will move to trash!!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                  })
                  .then((willDelete) => {
                  if (willDelete) {
                      
                      $.ajax ( {
                          type:"DELETE",
                          url:"/product/"+dlt_id,
                          data: {
                              "_token":$('input[name="_token"]').val(),//passing token for deleting
                              "id":dlt_id,
                          },
                          success: function(data) {
                              //console.log(data);
                              swal("Poof! Your data has been move to trash!", {
                              icon: "success",
                          }).then((willDelete) => {
                              location.reload();
                          });
                          }
                      })
                     
                  } 
                  });
            
  
        });
    $('body').on('click','.showProductDetails',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#showProduct').modal('toggle');   //showDetails is id of model
        $.get("/product/viewData/"+id,function(data){
            // console.log(data);
            $('#Nval').html(data.name);
            $('#Uval').html(data.unit);
            $('#PtypeVal').html(data.product_type);
            $('#Sval').html(data.status);
            $('#Rval').html(data.remark);
            $('#pCreatedBy').html(data.creator.name);
            $('#pUpdatedBy').html(data.editor.name);
       });
             
        });
        $(".alert").first().hide().slideDown(500).delay(4000).slideUp(500, function () {
            // document.getElementById('name').focus()
        $(this).remove();
        });
    }); 
  </script> 
@endsection
@endsection