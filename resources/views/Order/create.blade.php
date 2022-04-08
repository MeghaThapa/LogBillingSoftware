@extends('layouts.app')
@section('content')
<div class="container-fuild">
<div class="card card-body shadow mb-4">
    <center>
        <h1>Add New Order</h1>
    </center>
</div>
@if($errors->any())
<div class="alert alert-danger" role="alert">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</div>
@endif
{{-- <div class="card card-body"> --}}
  <div class="row">
    <div class="col-md-6">
    
<form action="/order" class="row g-3 needs-validation " method="POST" novalidate>
    @csrf
    <div class="row">
      <label for="validationCustom01" class="form-label fw-bold">Invoice Number</label>
      <div>
      <input type="text" class="form-control" disabled value= "{{ $invoice }}" name="invoice_number" id="validationCustom01" autofocus required>
    </div>
      {{-- <div class="invalid-feedback">
        
        Please fill bill number!
      </div> --}}
    </div>
    <div class="row">
        <label for="validationCustomUsername" class="form-label fw-bold">Customer Name</label>
        <div class="input-group has-validation">
          <select name="customerId" id="supplierSelect" class="form-control " required>
            <option value="" selected disabled>---select customer---</option>
              @foreach ($customer as $row)
                  <option value="{{$row->id }}">{{ $row->name}}</option>
              @endforeach
          </select>
          <div class="invalid-feedback">
            Please select customer name!!
          </div>
        </div>
      </div>
    <div class="row">
        <label for="validationCustom04" class="form-label fw-bold">Bill Date</label>
      <div>
        <input type="date"class="form-control" name="bill_date"id ="validationCustom04" required>
      </div>
        <div class="invalid-feedback">
          Please enter bill number!!
        </div>
    </div>
   <div class="row">
        <label for="validationCustom04" class="form-label fw-bold">Delivery Date</label>
      <div>
        <input type="date"class="form-control"name="delivery_date" id ="validationCustom04" >
      </div>
        <div class="invalid-feedback">
          Please enter transaction date!!
        </div>
      </div>
        <center>
          
            <button class="btn btn-primary" type="submit">Next</button>
         
        </center>
   
      
</form>
@section('PurchaseCreate')
  <script>
    $(document).ready(function() {
    //select2
    $('#supplierSelect').select2(
      {
        theme:'bootstrap-5'
      }
    );  
    
    //bootstrap input fieldvalidation
    var forms = document.querySelectorAll(".needs-validation");
    Array.prototype.slice.call(forms).forEach( function( form)
    {
      form.addEventListener("submit", function(event) 
      {
        if(!form.checkValidity())
        {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      }, false);
    }
    );
  }
  );
  </script>
</div>
</div>
</div>
{{-- <div class="col-md-6"></div> --}}

@endsection
@endsection