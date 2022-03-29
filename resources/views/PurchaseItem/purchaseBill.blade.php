@extends('layouts.app')
@section('content')
<div class="container">
   <center><h1>{{ $setting->name }}</h1>
    <p style="margin:0%;font-size:13px" class="m-0">{{ $setting->address }}</p>
    <p style="margin:0%;font-size:13px">Contact: {{ $setting->contact_number}}, Email:{{ $setting->email }}</p>
   </center> 
   <div class="row">
       <div class="col-md-3">
           <label class="fw-bold"for="">Bill From:</label>
           <label> {{ $purchase->name }}</label>
           <br>
           <label class="fw-bold"for="">Address:</label>
           <label>{{ $purchase->address }}</label>
       </div>
       <div class="col-md-6"></div>
       <div class="col-md-3">
           
           <label class="fw-bold" for="">Date:</label>
           <label>{{ $purchase->bill_date }}</label>
           <br>
           <label class="fw-bold" for="">Bill No:</label>
           <label>{{ $purchase->bill_no }}</label>
       </div>
   </div>
   <table class="table logTable" >
       <tr>
        <th>S.N</th>
        <th>Product Name</th>
        <th>Unit</th>
        <th>Rate</th>
        <th>Amount</th>
        <th>Discount %</th>
        <th>Discount Amount</th>
    </tr>
    <br>
    @php
    $i=1;
    @endphp
    <tbody>
        @foreach ($purchaseItem as $row) 
        <tr>
          <td>{{ $i++ }}</td>
          <td>{{ $row->name }}</td>
          <td>{{ $row->unit }}</td>
          <td>{{ $row->rate }}</td>
          <td>{{ $row->amount }}</td>
          <td>{{ $row->discount_percent }}</td>
          <td>{{ $row->discount_amount }}</td> 
        </tr> 
        @endforeach
    </tbody>
    
   
   </table>
   <div class="row">
       <div class="col-md-9"></div>
       <div class="col-md-3">
           <table>
               <tr>
                   <td class="fw-bold"> SUM TOTAL : </td>
                   <td>{{ $purchase->total_amount }}</td>
               </tr>
               <tr>
                <td class="fw-bold">DISCOUNT AMOUNT : </td>
                <td>{{ $purchase->discount_amount }}</td>
            </tr>
            <tr>
                <td class="fw-bold">NET AMOUNT:</td>
                <td>{{ $purchase->net_amount }}</td>
            </tr>

    </table>
    </div>
   </div>
</div>
@endsection