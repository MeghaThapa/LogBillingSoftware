@extends('layouts.app')
@section('content')
<center>
  <h1>Stock</h1>
</center>
<table class="table stock-table" width="100%" >
    <thead>
    <th>S.N</th>
    <th>Product Name</th>
    <th>Batch No</th>
    <th>Quantity</th>
    <th>Cost Price(C.P)</th>
    <th>Selling Price(C.P)</th>

</thead>
<tbody>
</tbody>
</table>
@section('Stock')
<script>
    $(document).ready(function(){
      $('.stock-table').DataTable({
       processing:true,
       serverSide:true,
       ajax:"{{ route('stock.stockData') }}",
       columns:[
       {data:'DT_RowIndex'},
       {data:'product_name'},
       {data:'batch_number'},
       {data:'quantity'},
       {data:'cp'},
       {data:'sp'}
       ]
     });
    });
  </script>  
@endsection
@endsection