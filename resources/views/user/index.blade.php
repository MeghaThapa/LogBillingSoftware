@extends('layouts.app')
@section('content')
<div class="card card-body shadow mb-5">
    <center>
        <h1>USER LIST</h1>
    </center>
</div>
<div class="card card-body shadow">
    <div class="row mb-5">
       <div class="col-md-10"></div>
       <div class="col-md-2">
        <a href="{{ route('user.create') }}">
           <div class ="btn btn-success"button> ADD USER</div>
        </a>
   </div>
</div>
<div class="row">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table class="table" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Register Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @php $i=0; @endphp
                    @foreach ($users as $userDetail )
                   
                        <tr>
                            
                            <td>{{ ++$i }}</td>
                            <td>{{ $userDetail->name }}</td>
                            <td>{{ $userDetail->email }}</td>
                            <td>{{ ($userDetail->role == 0)? "Cashier" : "Admin" }}</td>
                            <td>{{ $userDetail->created_at->toDateTimeString() }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('user.edit',['id'=>$userDetail->id]) }}">
                                    <i class="fas fa-user-edit fa-lg"></i>
                                </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="" class="changePW" data-id="{{ $userDetail->id }}" data-bs-toggle="modal" data-bs-target="#passwordChange">
                                        <i class="fas fa-key"></i>
                                </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="" class="dltservice" id="{{ $userDetail->id }}">
                                    <i class="fas fa-trash-alt fa-lg "></i>
                                </a>
                                </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
<!-- Modal -->
<div class="modal fade" id="passwordChange" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Change Password
        </h5>
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.editPW') }}" method="POST">
            @csrf
        <div class="modal-body">

          <div class="row">
              <input type="hidden" name="id" id="userId" hidden>
                <input type="text" placeholder="New Password" name="pass1" class="form-control mb-2 ">
                
                <input type="text" placeholder="Confirm Password" name="pass2" class="form-control ">
          </div>
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
  @section('userList')
  <script>
      $(document).ready(function(){
        $('.changePW').click(function(){
           const id=$(this).attr('data-id');
           $('#userId').val(id);
        //    $('#userId').hide();
        });

      });

      $(document).ready(function(){
        $('.dltservice').click(function(e){
         e.preventDefault();
          var dlt_id = $(this).attr('id');
        //   alert(dlt_id );
         swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    
                    $.ajax ( {
                        type:"DELETE",
                        url:"userList/delete/"+dlt_id,
                        data: {
                            "_token":$('input[name="_token"]').val(),
                            "id":dlt_id
                        },
                        success: function(data) {
                            //console.log(data);
                            swal("Poof! Your data has been deleted!", {
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