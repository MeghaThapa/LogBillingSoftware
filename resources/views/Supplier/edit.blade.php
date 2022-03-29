@extends('layouts.app')
@section('content')
<div class="container">
<div class="card card-body shadow mb-4">
    <center>
        <h1>Edit Supplier</h1>
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
    
<form action="/supplier/{{ $supplier->id }}" class="row g-3 needs-validation " method="POST" novalidate>
    @csrf
    @method('PUT')
    <div class="row">
      <label for="supplierName" class="form-label fw-bold">Name</label>
      <div>
      <input type="text" class="form-control" name="name" id="supplierName" value="{{ $supplier->name }}" autofocus required>
    </div>
      <div class="invalid-feedback">
        
        Please fill your name!
      </div>
    </div>
    <div class="row">
        <label for="supplierContact" class="form-label fw-bold">Contact</label>
        <div>
          <input type="number" class="form-control" name="contact" id="supplierContact" value="{{ $supplier->contact }}" required>
        </div>
          <div class="invalid-feedback">
            Please enter your contact number!!
          </div>
       
      </div>
    <div class="row">
      <label for="supplierAddress" class="form-label fw-bold">Address</label>
    <div>
      <input type="text" class="form-control" id="supplierAddress" name="address" value= "{{  $supplier->address}}" required>
    </div>
      <div class="invalid-feedback">
        Enter Address!!
      </div>
    </div>
    <div class="row">
        <label for="supplierPan" class="form-label fw-bold">Pan No</label>
      <div>
        <input type="number"class="form-control" name="pan_no"id ="supplierPan" value= "{{  $supplier->pan_no}}"required>
      </div>
        <div class="invalid-feedback">
          Please enter pan no!!
        </div>
    </div>
   <div class="row">
        <label for="supplierVat" class="form-label fw-bold">Vat No</label>
      <div>
        <input type="number"class="form-control"name="vat_no" id ="supplierVat" value= "{{  $supplier->vat_no}}" >
      </div>
        {{-- <div class="invalid-feedback">
          Please enter vat no!!
        </div> --}}
      </div>
      <div class="row">
        <label for="validationCustom04" class="form-label fw-bold">Remark</label>
      <div>
        <textarea type="text"class="form-control" id ="validationCustom04" name="remark"   >{{ $supplier->address}}
        </textarea>
        {{-- <div class="invalid-feedback">
          Please enter your contact no!!
        </div> --}}
      </div>
      </div>
      
          
        <center>
            <button class="btn btn-primary" type="submit">Submit form</button>
        </center>
   
      
</form>
<script>
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
    $(".alert").first().hide().slideDown(500).delay(4000).slideUp(500, function () {
            // document.getElementById('name').focus()
        $(this).remove();
        });
  </script>
</div>
</div>
</div>
<div class="col-md-6"></div>
{{-- </div> --}}
@endsection