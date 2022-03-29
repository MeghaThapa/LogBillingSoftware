@extends('layouts.app')
@section('content')
<center>
    <h1>
        Purchase Trash
    </h1>
</center>
    <table class="table table-striped table-bordered trashTable" width="100%" >
        <thead>
            <tr>
                <th>S.N</th>
                <th >Invoice Number</th>
                <th>Supplier Name</th>
                <th>Bill No</th>
                <th>Transaction Date</th>
                <th>Bill Date</th>
                <th>Net Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
        </tbody>
    </table>
@section('purchaseTrash')
   <script>
     $(document).ready(function(){
       $('.trashTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('purchase.trashTableData') }}",
        columns:[
        {data:'DT_RowIndex'},
        {data:'invoice_number'},
        {data:'name'},
        {data:'bill_no'},
        {data:'transaction_date'},
        {data:'bill_date'},
        {data:'net_amount'},
        {data:'action'}
        ]
        
      });
      $('body').on('click','.dltPurchase',function(){
            
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
                          url:"/purchase/purchaseTrashDelete/"+dlt_id,
                          data: {
                              "_token":$('input[name="_token"]').val(),//passing token for deleting
                              "id":dlt_id,
                          },
                          success: function(data) {
                            //   console.log(data);
                              if(data=='child'){
                                swal("You cannot delete this data as it exists in child table.", {
                              icon: "warning",
                                    })
                                    .then((willRestore) => {
                                        window.location="/purchase";
                                    });
                                // alert('Data can not be Deleted');
                                
                                  
                              }
                              else{
                              location.reload();

                              }
                          }
                      })
                     
                  } 
                  });
            
  
        });
         // For restoring
    $('body').on('click','.restorePurchase',function(){
            
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
                          url:"/purchase/restorePurchase/"+restore_id,
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
    });
    </script> 
@endsection

@endsection