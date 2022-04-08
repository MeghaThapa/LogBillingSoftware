@extends('layouts.app')
@section('content')
<div class="container-fuild">
<div class="card card-body shadow ">
    <div class="row">
        <div class="row">
            <div class="col-md-3">
                <label style="font-weight:bold;font-size:25px;font-family: 'Fredoka', sans-serif;">PURCHASE INVOICE </label>
            </div>
            <div class="col-md-6"></div>
          
            <div class="col-md-3 fw-bold" style="font-size:30px" >
                
                <i class="fa-solid fa-file-invoice fa-lg " style="color:red"></i>
                    <label for="" style="fw-bold"> INVOICING</label>
                
               
            </div>
        </div>
</div>
</div>

<div class="row">
    <div class="col-md-4">
        <label class="fw-bold">
            Sales Return FROM :
        </label>
        {{$salesreturn->name}}
        <br/>
        <label class="fw-bold">
            ADDRESS:
        </label>
        {{ $salesreturn->address }}
        <br/>
        <label class="fw-bold">
            INVOICE NUMBER:
        </label>
        {{ $salesreturn->invoice_number }}
        <br/>
    </div>      
<div class="col-md-4"></div>
<div class="col-md-4">
    <label class="fw-bold">
        BILL DATE: 
    </label>
    {{ $salesreturn->sales_return_date }}
    <br/>
    <label class="fw-bold">
        TRANSACTION DATE:
    </label>
    {{ $salesreturn->transaction_date }}
    <br/>
</div>
</div>
@if($errors->any())
<div class="alert alert-danger" role="alert">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</div>
@endif
<form action="{{ route('SalesItemReturn.save',['id'=>$salesreturn->id]) }}" class="needs-validation" method="POST" novalidate>
    @csrf
    
    <div class="row mt-4">  
        <div class="col-md-4">
            <label for="validationCustomUsername" class="form-label fw-bold needs-validation">Product Name/QTY/Rate</label>
            <div class="input-group has-validation">
              <select name="salesItem_id" id="productDetailSelect" class="form-select " required>
                <option value="" selected disabled>---select Product---</option>
                  @foreach ($productDetails as $row)
                      <option value="{{$row->id }}">Name: {{ $row->name}} / QTY: {{ $row->quantity }} /Rate: {{ $row->rate }}</option>
                  @endforeach
              </select>
              <div class="invalid-feedback">
                Please select supplier name!!
              </div>
            </div>
        </div>
        <div class="col-md-4">
            {{-- <div class="label fw-bold">Quantity</div>  --}}
            <label for="validationQuantity" class="form-label fw-bold">Quantity</label> 
            {{-- <input type="number"class="form-control" name="bill_date"id ="validationCustom04" required> --}}
            <input type="number" name="quantity" id="validationQuantity"  class="form-control" required/>
            <div class="invalid-feedback">
                Please enter quantity!!
              </div>
        </div>
        <div class="col-md-4" style="margin-top:30px">   <button type="submit" class="btn btn-primary">Submit</button></div>

    </div>

</form>
<table class="table table-striped table-bordered table-hover" style="margin-top:30px">
    <thead>
       <th>S.N</th>
       <th>Product Name</th>
       <th>Unit</th>
       <th>Quantity</th>
       <th>Rate</th>
       <th>Amount</th>
       <th>Action</th>
    </thead>
    <tbody>
        @php
            $i=0;
        @endphp
        @foreach ($salesItemReturn as $row)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->unit }}</td>
                <td>{{ $row->quantity }}</td>
                <td>{{ $row->rate }}</td>
                <td>{{ $row->amount }}</td>
                <td>
                    <a class="dltItem" id="{{ $row->id }}">
                        <i class="fas fa-trash-alt fa-lg">  </i>
                    </a>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
<table style="float:right;margin-right:350px">
 <tr>
     <td class="fw-bold">NET AMOUNT : </td>
     <td>  &#160;{{ $salesItemReturn->sum('amount') }}</td>
 </tr>

</table>
<br>
<br>
<hr>
<div class=" mt-4 ">
    <form action="{{ route('SalesReturn.netAmountSave',['id'=>$salesreturn->id]) }}" method="POST">
        @csrf
    <center>
       
    <button class="btn btn-primary">Save</button>
</center>
</form>
</div>
</div>
@section('salesItemReturn')
   <script> 
$(document).ready(function(){
    $("#productDetailSelect").select2(
      {
        theme:'bootstrap-5',
       
      }
    ); 
}); 
$('body').on('click','.dltItem',function(){
    var dlt_id = $(this).attr('id');
    $.ajax ( {
                        type:"DELETE",
                        url:"/salesItemReturn/delete/"+dlt_id,
                        data: {
                            "_token":$('input[name="_token"]').val(),//passing token for deleting
                            "id":dlt_id,
                        },
                        success: function(data) {
                            location.reload();
                        }
                    })
  });
$(".alert").first().hide().slideDown(500).delay(4000).slideUp(500, function () {
            // document.getElementById('name').focus()
        $(this).remove();
        });

  </script> 
@endsection
@endsection