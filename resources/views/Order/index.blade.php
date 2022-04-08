@extends('layouts.app')
@section('content')
<center>
<h1>Order Dashboard</h1>
</center>
<div class="row mb-2">
    <div class="col-md-9"></div>
    <div class="col-md-1">
        <a >
        <div class="btn btn-danger">Trash</div>
     </a>
    </div>
    <div class="col-md-2">
     <a href="{{ route('order.create') }}">
        <div class ="btn btn-success"button> ADD ORDER</div>
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
            <table class="table table-striped table-bordered orderTable" width="100%" >
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th >Invoice Number</th>
                        <th>Customer Name</th>
                        <th>Bill Date</th>
                        <th>Total Amount</th>
                        <th>Total Discount</th>
                        <th>Advance Payment</th>
                        <th>Net Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                </tbody>
            </table>
        </div>
</div> 
@section('order')
    
<script>
$(document).ready(function(){
    $('.orderTable').DataTable({
     processing:true,
     serverSide:true,
     ajax:"{{ route('order.ajaxTableData') }}",
     columns:[
     {data:'DT_RowIndex'},
     {data:'invoice_number'},
     {data:'name'},
     {data:'transaction_date'},
     {data:'total_amount'},
     {data:'discount_amount'},
     {data:'advance_payment'},
     {data:'net_amount'},
     {data:'action'}
     ]
   });
});
</script>
@endsection
@endsection