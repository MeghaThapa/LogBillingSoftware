@extends('layouts.app')
@section('content')
<div class="row">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
             Supplier DataTable 
        </div>
        <div>
            <center >
                <h1 class="fw-bold textcolor-danger" style="color: red">Trash Data</h1>
            </center>
        </div>
        <br>
        <div class="card-body">
            <table class="table table-striped table-bordered supplierTable" width="100%" >
                <thead>
                    <tr>
                       <th>S.N</th>
                        <th >Name</th>
                        <th>contact</th>
                        <th>Address</th>
                        <th>Vat.No</th>
                        <th>Pan.No</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                </tbody>
            </table>
        </div>
</div>

@section('SupplierTrash')
<script>
    $(document).ready(function(){
     var table=  $('.supplierTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('supplier.trashData') }}",
        columns:[
        {data:'DT_RowIndex'},
        {data:'name'},
        {data:'contact'},
        {data:'address'},
        {data:'vat_no'},
        {data:'pan_no'},
        {data:'remark'},
        {data:'actions'}
        ]
      });
      
    }); 
    //For restoring
    $('body').on('click','.restore',function(){
            
            var restore_id = $(this).attr('id');
            //alert(dlt_id );
           swal({
                  title: "Do you want to restore data?",
                  text: "Your data will be recovered!",
                  icon: "info",
                  buttons: true,
                  dangerMode: false,
                  })
                  .then((willRestore) => {
                  if (willRestore) {
                      
                      $.ajax ( {
                          type:"POST",
                          url:"/supplier/restoreSupplier/"+restore_id,
                          data: {
                              "_token":$('input[name="_token"]').val(),//passing token for deleting
                              "id":restore_id,
                          },
                          success: function(data) {
                              //console.log(data);
                              swal("Poof! Your data has been recovered!", {
                              icon: "success",
                          }).then((willReload) => {
                              location.reload();
                          });
                          }
                      })
                     
                  } 
                  });
            
  
          });
          //for deleting
          $('body').on('click','.dltSupplier',function(){
            
            var delete_id = $(this).attr('id');
            //alert(dlt_id );
           swal({
                  title: "Do you want to delete data?",
                  text: "Your data will be parmanaently deleted!",
                  icon: "danger",
                  buttons: true,
                  dangerMode: true,
                  })
                  .then((willDelete) => {
                  if (willDelete) {
                      
                      $.ajax ( {
                          type:"DELETE",
                          url:"/supplier/trashDelete/"+delete_id,
                          data: {
                              "_token":$('input[name="_token"]').val(),//passing token for deleting
                              "id":delete_id,
                          },
                          success: function(data) {
                              //console.log(data);
                              swal("Poof! Your data has been deleted!", {
                              icon: "success",
                          }).then((willReload) => {
                              location.reload();
                          });
                          }
                      })
                     
                  } 
                  });
            
  
          });
</script>   
@endsection
@endsection