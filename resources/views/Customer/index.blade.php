@extends('layouts.app')
@section('content')
<div class="card card-body shadow mb-5">
    <center>
        <h1>CUSTOMER DASHBOARD</h1>
    </center>
</div>


    <div class="row mb-2">
       <div class="col-md-9"></div>
       <div class="col-md-1">
           <a href="{{ route('customer.trash') }}">
           <div class="btn btn-danger">Trash</div>
        </a>
       </div>
       <div class="col-md-2">
        <a href="{{ route('customer.create') }}">
           <div class ="btn btn-success"button> ADD CUSTOMER</div>
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
            <table class="table table-striped table-bordered customerTable" width="100%" >
                <thead>
                    <tr>
                       
                        <th >Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Contact No 1</th>
                        <th>Contact No 2</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                </tbody>
            </table>
        </div>
</div> 
{{-- model --}}
<div class="modal fade" id="showDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            View Customer Details
        </h5>
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
            @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4"><b>Name :</b></div>
                <div class="col-sm-6">
                    <p id="Cname">

                    </p>
                </div>
                <div class="col-sm-4"><b>Email :</b></div>
                <div class="col-sm-6">
                    <p id="Cemail">

                    </p>
                </div>
                <div class="col-sm-4"><b>Address :</b></div>
                <div class="col-sm-6">
                    <p id="Caddress">

                    </p>
                </div>
                <div class="col-sm-4"><b>Contact No 1 :</b></div>
                <div class="col-sm-6">
                    <p id="Ccontact1">

                    </p>
                </div>
                <div class="col-sm-4"><b>Contact_no_2 :</b></div>
                <div class="col-sm-6">
                    <p id="Ccontact2">

                    </p>
                </div>
            </div>
            <div class="col-sm-4"><b>Remark :</b></div>
                <div class="col-sm-6">
                    <p id="Cremark">

                    </p>
                </div>
         
    
      </div>
    </div>
  </div>
@section('customerIndex')
  <script>
    $(document).ready(function(){
     var table=  $('.customerTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('customer.indexAjax') }}",
        columns:[
        {data:'name'},
        {data:'email'},
        {data:'address'},
        {data:'contact_no_1'},
        {data:'contact_no_2'},
        {data:'remark'},
        {data:'action'}
        ]
      });
    }); 

   
        $('body').on('click','.dltCustomer',function(){
            
          var dlt_id = $(this).attr('id');
          //alert(dlt_id );
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
                        url:"/customer/"+dlt_id,
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
        
        $('body').on('click','.showCustomerModel',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#showDetails').modal('toggle');   //showDetails is id of model
        $.get("/customer/modelData/"+id,function(data){
            // console.log(data);
            $('#Cname').html(data.name);
            $('#Cemail').html(data.email);
            $('#Caddress').html(data.address);
            $('#Ccontact1').html(data.contact_no_1);
            $('#Ccontact2').html(data.contact_no_2);
            $('#Cremark').html(data.remark);
        });
        $(".alert").first().hide().slideDown(500).delay(4000).slideUp(500, function () {
            // document.getElementById('name').focus()
        $(this).remove();
        });
        });
 
  </script>
@endsection
@endsection