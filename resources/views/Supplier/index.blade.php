@extends('layouts.app')
@section('content')
<div class="container">
<div class="card card-body shadow mb-5">
    <center>
        <h1>SUPPLIER DASHBOARD</h1>
    </center>
</div>


    <div class="row mb-2">
       <div class="col-md-9"></div>
       <div class="col-md-1">
           <a href=" {{ route('supplier.trash') }}">
           
           <div class="btn btn-danger">Trash</div>
        </a>
       </div>
       <div class="col-md-2">
        <a href="{{ route('supplier.create') }}">
            
           <div class ="btn btn-success"button> ADD SUPPLIER</div>
        </a>
   </div>
    </div>

<div class="row">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
             Supplier DataTable 
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered supplierTable" width="100%" >
                <thead>
                    <tr>
                       <th>S.N</th>
                        <th >Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Pan No</th>
                        <th>Vat No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div> 
{{-- model --}}
<div class="modal fade" id="showDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            View Suppliers Detail
        </h5>
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
            
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4"><b>Name :</b></div>
                <div class="col-sm-6">
                    <p id="Sname">

                    </p>
                </div>
                <div class="col-sm-4"><b>Contact :</b></div>
                <div class="col-sm-6">
                    <p id="Scontact">

                    </p>
                </div>
                <div class="col-sm-4"><b>Address :</b></div>
                <div class="col-sm-6">
                    <p id="Saddress">

                    </p>
                </div>
                <div class="col-sm-4"><b>Pan.No :</b></div>
                <div class="col-sm-6">
                    <p id="Span_no">

                    </p>
                </div>
                <div class="col-sm-4"><b>Vat.No :</b></div>
                <div class="col-sm-6">
                    <p id="Svat_no">

                    </p>
                </div>
            
            <div class="col-sm-4"><b>Remark :</b></div>
                <div class="col-sm-6">
                    <p id="Sremark">

                    </p>
                </div>
                <div class="col-sm-4"><b>Created By :</b></div>
                <div class="col-sm-6">
                    <p id="SCreatedBy">

                    </p>
                </div>
                <div class="col-sm-4"><b>Updated By :</b></div>
                <div class="col-sm-6">
                    <p id="SUpdatedBy">

                    </p>
                </div>
            </div>
    
      </div>
    </div>
  </div>
  </div>
@section('SupplierList')
  <script>
    $(document).ready(function(){
       $('.supplierTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('supplier.indexAjax') }}",
        columns:[
        {data:'DT_RowIndex'},
        {data:'name'},
        {data:'address'},
        {data:'contact'},
        {data:'pan_no'},
        {data:'vat_no'},
        {data:'action'}
        ]
      });
    }); 

   
        $('body').on('click','.dltSupplier',function(){
            
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
                        url:"/supplier/"+dlt_id,
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
        
        $('body').on('click','.showSupplierModel',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#showDetails').modal('toggle');   //showDetails is id of model
        $.get("/supplier/modelData/"+id,function(data){
            // console.log(data);
            $('#Sname').html(data.name);
            $('#Scontact').html(data.contact);
            $('#Saddress').html(data.address);
            $('#Span_no').html(data.pan_no);
            $('#Svat_no').html(data.vat_no);
            $('#Sremark').html(data.remark);
            $('#SCreatedBy').html(data.creator.name);
            $('#SUpdatedBy').html(data.editor.name);
       });
             
        });
 
  </script> 
@endsection
@endsection