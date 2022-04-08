@extends('layouts.app')
@section('content')

<div class="card card-body shadow ">
            <div class="row">
                <div class="col-md-3">
                    <label style="font-weight:bold;font-size:25px;font-family: 'Fredoka', sans-serif;">SERVICE ITEM INVOICE </label>
                </div>
                <div class="col-md-6"></div>
              
                <div class="col-md-3 fw-bold" style="font-size:30px" >
                    
                    <i class="fa-solid fa-file-invoice fa-lg " style="color:red"></i>
                        <label for="" style="fw-bold"> INVOICING</label>
                    
                   
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="fw-bold">
                        ORDER BY :
                    </label>
                    {{$order->name}}
                    <br/>
                    <label class="fw-bold">
                        ADDRESS:
                    </label>
                    {{ $order->address }}
                    <br/>
                    <label class="fw-bold">
                        INVOICE NUMBER:
                    </label>
                    {{ $order->invoice_number }}
                    <br/>
                </div>      
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <label class="fw-bold mt-4">
                    ORDER DATE: 
                </label>
                {{ $order->transaction_date }}
                <br/>
                <label class="fw-bold">
                    DELIVERY DATE:
                </label>
                {{ $order->delivery_date }}
                <br/>
            
            
            </div>
            </div>
</div>
<br>
<form action="{{ route('ServiceItem.save',['id'=>$order->id]) }}" class="needs-validation" method="POST" novalidate>
    @csrf
    
    <div class="row"> 
        <div class="col-md-3">
            <label for="validationCustomUsername" class="form-label fw-bold needs-validation">Order Item Name</label>
            <div class="input-group has-validation">
              <select name="orderItem_id" id="orderItemSelect" class="form-select needs-validation " required>
                <option value="" selected disabled>---select order item name---</option>
                  @foreach ($orderItemName as $row)
                      <option value="{{$row->id }}">{{ $row->name}}</option>
                  @endforeach
              </select>
              <div class="invalid-feedback">
                Please select supplier name!!
              </div>
            </div>
        </div> 
        <div class="col-md-3">
            <label for="validationCustomUsername" class="form-label fw-bold needs-validation">Product Name</label>
            <div class="input-group has-validation">
              <select name="product_id" id="productSelect" class="form-select needs-validation " required>
                <option value="" selected disabled>---select Product---</option>
                  @foreach ($product as $row)
                      <option value="{{$row->id }}">{{ $row->name}}</option>
                  @endforeach
              </select>
              <div class="invalid-feedback">
                Please select supplier name!!
              </div>
            </div>
        </div>
        <div class="col-md-3" id="stockDiv" style="margin-top:8px;display:none" >
            <label for="" style="font-weight:bold">Stock</label>
            <select name="stock_id" id="stockDetails" class="form-select">

            </select>
        </div>
        <div class="col-md-3">

            <label for="validationQuantity" class="form-label fw-bold ">Quantity</label> 

            <div class="input-group mb-3">
            <input type="text" class="form-control needs-validation" name="quantity" placeholder="Add Quantity " id="validationQuantity" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-list-ol"></i></span>
            <div class="invalid-feedback">
                Please enter quantity!!
              </div>
        </div>
        </div>
      
    </div>
    <div class="row">
        <div class="col-md-4"></div>
    <div class="col-md-4 " style="margin-top:32px">
          <button type="submit" class="btn btn-primary">Submit</button>

    </div>
    <div class="col-md-4"></div>
</div>
</form>
<table class="table table-bordered purchaseItemTable" style="margin-top: 15px" >
    <thead>
    <tr>
        <th>
            S.N
        </th>
        <th>
            Product Name
        </th>
        <th>
            Quantity
        </th>
        <th>
            Rate
        </th>
        <th>
            Amount
        </th>
        <th>
            Profit
        </th>

        <th>
            sp
        </th>
        <th>
            Action
        </th>
    </tr>
</thead>
<tbody>
    @php
        $i=0;
    @endphp
    @foreach ($serviceItem as $row )
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->quantity }}</td>
                <td>{{ $row->cp }}</td>
                <td>{{ $row->amount }}</td>
                <td>{{ $row->profit_total }}</td>
                <td>{{ $row->sp }}</td>
                <td>
                 <a id="{{$row->id}}" class="serviceEdit">
                     <i class="fas fa-user-edit fa-lg "></i>
                 </a>
            &#160
        <a class="dltServiceItem" id="{{ $row->id }}">
            <i class="fas fa-trash-alt fa-lg">  </i>
        </a>
                </td>
            </tr>
    @endforeach
</tbody>
</table>
{{-- edit modal --}}
<div class="modal fade" id="serviceModalEdit"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            
          <h5 class="modal-title" id="exampleModalLabel">
         Edit Purchase Items
        </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('serviceItem.saveEdit') }}" method="POST">
            @csrf
           
        <div class="modal-body">
            <input type="text" name="id" id="sIid" hidden >
          <div class="row">
           
            <div class="row m-2">
                <div class="col-md-4">
                   <label for="nameV" class="form-label fw-bold">Product Name</label>
                </div>
                <div class="col-md-8">
                    <select name="product_id" id="selectModelProduct" class="form-select">
                        @foreach ($product as $row)
                        <option value="{{$row->id}}">{{ $row->name}}</option>
                    @endforeach
                </select>
            </div>
           </div>
           <div class="row m-2">
           
            <div class="col-md-4">
                <label for="nameV" class="form-label fw-bold">Stock</label>
             </div>
             <div class="col-md-8">
            <select name="stock_id" id="sIstock_id" class="form-select">
            </select>

            </div>
       
           </div>

            
           <div class="row m-2">
           
            <div class="col-md-4">
                <label for="nameV" class="form-label fw-bold">Quantity</label>
             </div>
             <div class="col-md-8">
            <input type="number" name="quantity" class="form-control" min="1" id="sIquantity" step="0.01">
            </div>
            
       
           </div>
            
          </div>
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          
          <button type="submit" class="btn btn-primary">Save</button>
       
        </div>
    </form>
    
      </div>
     
    </div>
  </div>
  <div class="card">
      <div class="card-body shadow">
  <center>
      <a href="{{ route('serviceItem.completeItem',['id'=>$order->id]) }} ">
          <button type="submit" class="btn btn-primary">SAVE</button>
      </a>
  </center>
</div>
</div>
@section('serviceItem')
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
    

    $('.purchaseItemTable').DataTable({
        "paging": false,
    "bPaginate": false,
   });


    $(".alert").first().hide().slideDown(500).delay(4000).slideUp(500, function () {
            // document.getElementById('name').focus()
        $(this).remove();
        }); 

    $('body').on('click','.serviceEdit',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#serviceModalEdit').modal('toggle');   //showDetails is id of model
        $.get("/ServiceItem/editData/"+id,function(data){
            // console.log(data);
            $('#selectModelProduct').val(data.product_id);
            $("#selectModelProduct").select2(
                        {
                            theme:'bootstrap-5',
                            dropdownParent:$('#serviceModalEdit')
                        }
                    ).trigger('change'); 
            
            $('#sIid').val(data.id);
            
            $('#sIquantity').val(data.quantity);
            $('#sIstock_id').val(data.stock_id);
            $('#selectModelProduct').val(data.product_id);
           
       });
             
    });
    $('body').on('click','.dltServiceItem',function(){
    var dlt_id = $(this).attr('id');
    $.ajax ( {
                        type:"DELETE",
                        url:"/ServiceItem/delete/"+dlt_id,
                        data: {
                            "_token":$('input[name="_token"]').val(),//passing token for deleting
                            "id":dlt_id,
                        },
                        success: function(data) {
                            location.reload();
                        }
                    })
  });
    $('#selectModelProduct').change(function () {
        var id=$(this).val();
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/ServiceItem/stockData/"+id,
            data:{id},
            success: function (data){
                console.log(data);
                $('#sIstock_id').empty();
                $.each(data, function(index,stock){
                    $('#sIstock_id').append('<option data-rate="'+stock.sp+'" value="'+ stock.id + '">'+'Batch:-' + stock.batch_number + ' / '+'Qty:-'
        + stock.quantity +' / ' +'Sp:- '+ stock.sp + '</option>')
                })
            }
        })
    });
    $('#productSelect').change(function () {
        
        var id=$(this).val();

        $.ajax({
            type: "GET",
            url: "/ServiceItem/stockData/"+id,
            data:{id},
            success: function (data){
                console.log(data);
                $('#stockDiv').show();
                $('#stockDetails').empty();
                $.each(data, function(index,stock){
                    $('#stockDetails').append('<option data-rate="'+stock.sp+'" value="'+ stock.id + '">'+'Batch:-' + stock.batch_number + ' / '+'Qty:-'
        + stock.quantity +' / ' +'Sp:- '+ stock.sp + '</option>')
                })
            }
        })
    });

    </script> 
@endsection
@endsection