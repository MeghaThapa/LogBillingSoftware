@extends('layouts.app')
@section('content')
<div class="row">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
             Product DataTable 
        </div>
        <div>
            <center >
                <h1 class="fw-bold textcolor-danger" style="color: red">Product Trash Data</h1>
            </center>
        </div>
        <br>
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

@section('ProductTrash')
<script>
    $(document).ready(function(){
     var table=  $('.productTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('product.trashData') }}",
        columns:[
        {data:'DT_RowIndex'},
        {data:'name'},
        {data:'unit'},
        {data:'product_type'},
        {data:'status'},
        {data:'remark'},
        {data:'actions'}
        ]
      });
      
    }); 
    // For restoring
    $('body').on('click','.restoreProduct',function(){
            
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
                          url:"/product/restoreProduct/"+restore_id,
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
          $('body').on('click','.dltProduct',function(){
            
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
                          url:"/product/trashDelete/"+delete_id,
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