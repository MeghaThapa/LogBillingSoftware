@extends('layouts.app')
@section('content')
<div class="container">
<div class="card card-body shadow mb-4">
    <center>
        <h1>Edit Customer</h1>
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
    
<form action="\customer\{{ $data->id }}" class="row g-3 needs-validation " method="POST" novalidate>
    @csrf
    @method('PUT')
    <div class="row">
      <label for="validationCustom01"  class="form-label fw-bold">Name</label>
      <div>
      <input type="text" class="form-control" value="{{ $data->name }}" autofocus name="name" id="validationCustom01" required>
    </div>
      <div class="invalid-feedback">
        
        Please fill your name!
      </div>
    </div>
    <div class="row">
        <label for="validationCustomUsername" class="form-label fw-bold">Email</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
          <input type="email" class="form-control" value="{{ $data->email }}"name="email" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
          <div class="invalid-feedback">
            Please enter your email address!!
          </div>
        </div>
      </div>
    <div class="row">
      <label for="validationCustom02" class="form-label fw-bold">Address</label>
    <div>
      <input type="text" value="{{ $data->address }}"  class="form-control" id="validationCustom02" name="address" required>
    </div>
      <div class="invalid-feedback">
        Enter Address!!
      </div>
    </div>
    <div class="row">
        <label for="validationCustom04" class="form-label fw-bold">Phone No 1</label>
      <div>
        <input type="number" value="{{ $data->contact_no_1 }}"class="form-control" name="contact_no_1"id ="validationCustom04" required>
      </div>
        <div class="invalid-feedback">
          Please enter your contact no!!
        </div>
    </div>
   <div class="row">
        <label for="validationCustom04" class="form-label fw-bold">Phone No 2</label>
      <div>
        <input type="number" value="{{ $data->contact_no_2 }}"class="form-control"name="contact_no_2" id ="validationCustom04" >
      </div>
        {{-- <div class="invalid-feedback">
          Please enter your contact no!!
        </div> --}}
      </div>
      <div class="row">
        <label for="validationCustom04" class="form-label fw-bold">Remark</label>
      <div>
        <textarea type="text" class="form-control" id ="validationCustom04" name="remark" >
            {{ $data->remark }}
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
  </script>
</div>
</div>
</div>
<div class="col-md-6"></div>
{{-- </div> --}}
@endsection