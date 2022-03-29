@extends('layouts.app')
@section('content')
<div class="card card-body shadow mb-5">
    <center>
        <h1>PURCHASE DASHBOARD</h1>
    </center>
</div>


    <div class="row mb-2">
       <div class="col-md-9"></div>
       <div class="col-md-1">
           <a href="{{ route('purchase.trash') }}">
           <div class="btn btn-danger">Trash</div>
        </a>
       </div>
       <div class="col-md-2">
        <a href="{{ route('purchase.create') }}">
           <div class ="btn btn-success"button> ADD PURCHASE</div>
        </a>
   </div>
    </div>

<div class="row">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
             Customer DataTable 
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered purchaseTable" width="100%" >
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
        </div>
</div> 
{{-- show purchase --}}
<div class="modal fade" id="showPurchase"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            
          <h5 class="modal-title fw-bold" id="exampleModalLabel" >
         Purchase Details
        </h5>
    
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-5 mb-3"><b>Supplier's Name :</b></div>
                <div class="col-sm-6 mb-3">
                    <p id="nValue">

                    </p>
                </div>
                
                <div class="col-sm-5 mb-3"><b>Bill No:</b></div>
                <div class="col-sm-6 mb-3">
                    <p id="bilNoVal">

                    </p>
                </div>
                <br>
                <div class="col-sm-5 mb-3"><b>Transaction Date :</b></div>
                <div class="col-sm-6 mb-3">
                    <p id="transacVal">

                    </p>
                </div>
                <div class="col-sm-5 mb-3"><b>Discount Amount:</b></div>
                <div class="col-sm-6 mb-3">
                    <p id="disVal">

                    </p>
                </div>
            <div class="col-sm-5 mb-3"><b>Paid amount:</b></div>
                <div class="col-sm-6 mb-3">
                    <p id="namtVal">

                    </p>
                </div>
                <div class="col-sm-5 mb-3"><b>Status:</b></div>
                <div class="col-sm-6 mb-3">
                    <p id="sVal">

                    </p>
                </div>
            </div>
    
      </div>
      </div>
    </div>
  </div>
@section('purchaseList')
    <script>
     $(document).ready(function(){
       $('.purchaseTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('purchase.ajaxTableData') }}",
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
      $('body').on('click','.showPurchaseDetails',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#showPurchase').modal('toggle');   //showDetails is id of model
        $.get("/purchase/modelData/"+id,function(data){
            
            $('#nValue').html(data.name);
            $('#disVal').html(data.discount_amount);
            $('#namtVal').html(data.net_amount);
            $('#sVal').html(data.status);
            $('#bilNoVal').html(data.bill_no);
            $('#transacVal').html(data.transaction_date);
       });
             
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
                          url:"/purchase/"+dlt_id,
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
        
    }); 
    </script>
@endsection
@endsection