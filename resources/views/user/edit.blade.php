@extends('layouts.app')
@section('content')
<div class="container">
<div class="card card-body shadow mb-4">
    <center>
        <h1>Edit User</h1>
    </center>
</div>
<div class="card card-body">
<form action="{{ route('user.update',['id'=>$user->id]) }}" class="row g-3 needs-validation " method="POST" novalidate>
    @csrf
    <div class="col-md-4">
      <label for="validationCustom01" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{ $user->name }}" id="validationCustom01" required>
      <div class="invalid-feedback">
        Please fill your name!
      </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Email</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
          <input type="text" class="form-control" value="{{ $user->email }}" name="email" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
          <div class="invalid-feedback">
            Please enter your email address!!
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustom04" class="form-label">Position</label>
        <select class="form-select"  name="position" id="positionvalidationCustom04" required>
          <option selected disabled value="">Choose...</option>
          <option value="0" {{ ($user->role==0)?'selected':'' }}>Cashier</option>
          <option value="1"{{ ($user->role==1)?'selected':'' }}>Admin</option>
        </select>
        <div class="invalid-feedback">
          Please select a position.
        </div>
      </div>
      <div class="col-md-4"></div>
   
      <div class="col-12">
        <center>
            <button class="btn btn-primary" type="submit">Submit</button>
        </center>
      </div>
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
@endsection