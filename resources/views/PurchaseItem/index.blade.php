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
            BILL FROM :
        </label>
        {{$purchase->name}}
        <br/>
        <label class="fw-bold">
            ADDRESS:
        </label>
        {{ $purchase->address }}
        <br/>
        <label class="fw-bold">
            INVOICE NUMBER:
        </label>
        {{ $purchase->invoice_number }}
        <br/>
    </div>      
<div class="col-md-4"></div>
<div class="col-md-4">
    <label class="fw-bold">
        BILL DATE: 
    </label>
    {{ $purchase->bill_date }}
    <br/>
    <label class="fw-bold">
        TRANSACTION DATE:
    </label>
    {{ $purchase->transaction_date }}
    <br/>


</div>
</div>
<br>
<form action={{route('purchaseItem.saveData',['id'=>$purchase->id ]) }} class="needs-validation" method="POST" novalidate>
    @csrf
    
    <div class="row">  
        <div class="col-md-3">
            <label for="validationCustomUsername" class="form-label fw-bold needs-validation">Product Name</label>
            <div class="input-group has-validation">
              <select name="product_id" id="productSelect" class="form-control " required>
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
        <div class="col-md-2">
            {{-- <div class="label fw-bold">Quantity</div>  --}}
            <label for="validationQuantity" class="form-label fw-bold">Quantity</label> 
            {{-- <input type="number"class="form-control" name="bill_date"id ="validationCustom04" required> --}}
            <input type="number" name="quantity" id="validationQuantity"  class="form-control" required/>
            <div class="invalid-feedback">
                Please enter quantity!!
              </div>
        </div>
        <div class="col-md-2">
            <label for="validationRate" class="form-label fw-bold">Rate</label> 
            <input type="number" name="rate" id="validationRate"  class="form-control" required/>
            <div class="invalid-feedback">
                Please enter rate!!
              </div>
        </div>
        <div class="col-md-2">
            <label for="validationDiscount" class="form-label fw-bold" >Discount %</label> 
            <input type="number" name="discountP" id="disPer" class="form-control" />
           
        </div>
        <div class="col-md-3">
            <label for="validationDiscountA" class="form-label fw-bold ">Discount Amount</label> 
            <input type="number" name="discountA"  id="DiscountA"  class="form-control" />
        </div>
        <div class="col-md-3">
            <label for="sp" class="form-label fw-bold ">Selling Amount</label> 
            <input type="number" name="spA"  id="sp"  class="form-control" />
        </div>
        
    <div class="row mt-3">
        <div class="col-md-5"></div>
        <div class="col-md-2">   <button type="submit" class="btn btn-primary">Submit</button></div>
     <div class="col-md-5"></div>
    </div>
    </div>
</form>
<div>
    <table class="table table-bordered purchaseItemTable"  >
        <thead>
        <tr>
            <th>
                S.N
            </th>
            <th>
                Product Name
            </th>
            <th>
                Unit
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
                Discount %
            </th>
            <th>
                Discount Amount
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
        @foreach ($purchaseItem as $row )
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->unit }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->rate }}</td>
                    <td>{{ $row->amount }}</td>
                    <td>{{ $row->discount_percent }}</td>
                    <td>{{ $row->discount_amount }}</td>
                    <td>
                     <a id="{{$row->id}}" class="purchaseItemE">
                         <i class="fas fa-user-edit fa-lg "></i>
                     </a>
                &#160
            <a class="dltItem" id="{{ $row->id }}">
                <i class="fas fa-trash-alt fa-lg">  </i>
            </a>
                    </td>
                </tr>
        @endforeach
    </tbody>
    </table>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <table>
                <tr>
                    <td class="fw-bold">Total Amount:</td>
                    <td class="fw-bold">Rs.{{ $purchaseItem->sum('amount') }}</td>  
                </tr>
               
                <tr>
                    <td class="fw-bold"> Total Discount:</td>
                   <td class="fw-bold">Rs.{{ $purchaseItem->sum('discount_amount') }}</td>
                </tr>
                
                <tr>
                    <td class="fw-bold"> Payable Amount:</td>
                   <td class="fw-bold">Rs.{{ $purchaseItem->sum('amount') - $purchaseItem->sum('discount_amount') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

{{-- edit modal --}}
<div class="modal fade" id="purchaseItemEdit"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            
          <h5 class="modal-title" id="exampleModalLabel">
         Edit Purchase Items
        </h5>
    
    
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('purchaseItem.updateSave') }}" method="POST">
            @csrf
           
        <div class="modal-body">
            <input type="text" name="id" id="pIid" hidden >
          <div class="row">
           
            <div class="row m-2">
                <div class="col-md-4">
                   <label for="nameV" class="form-label fw-bold">Product Name</label>
                </div>
                <div class="col-md-8">
                    <select name="product_id" id="selectProduct" class="form-control">
                    @foreach ($product as $row)
                      <option value="{{$row->id }}">{{ $row->name}}</option>
                  @endforeach   
                </select>
            </div>
           </div>
            
            
             <div class="row m-2">
                 <div class="col-md-4">
                    <label for="nameV" class="form-label fw-bold">Quantity</label>
                 </div>
                 <div class="col-md-8">
                     <input type="text"  name="quantity" id="pIquantity" class="form-control mb-2 ">
                 </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
               <label class="form-label fw-bold">Rate</label>
            </div>
            <div class="col-md-8">
                <input type="text"  name="rate" id="pIrate" class="form-control mb-2 ">
            </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Discount %</label>
                </div>
                <div class="col-md-8">
                    <input type="text"  name="discount_percent" id="pIdiscount_percent" class="form-control mb-2 ">
                </div>
            </div>
            <div class="row m-2">
                <div class="col-md-4">
                    <label for="remarkV"  class="form-label fw-bold">Dis Amount</label>
                </div>
                <div class="col-md-8">
                    <input type="text"  name="discount_amount" id="pIdiscount_amount" class="form-control mb-2 ">

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
  <hr style="border-top:bold">
    {{-- {{ $purchase->invoice_number }} --}}
      <form action="{{ route('purchase.save',['id'=>$purchase->id]) }}" method="POST">
        @csrf
        <div class="row" >

      <div class="col-md-4" >
        <label for="vat" class="fw-bold">VAT</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="vat" placeholder="Add Vat Amount" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-money-check-dollar"></i></span>
        </div>  
        </div>
        <div class="col-md-4">
          <label for="vat" class="fw-bold">Extra Charge</label>
          
          <div class=" input-group mb-3">
              <input type="text" class="form-control" name="extraCharge" placeholder="Add Extra Charges" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-money-check-dollar"></i></span>
            </div>
        </div>
      <div class="col-md-4 mt-4">
          
        <button type= "submit"class="btn btn-primary"> Save</button>
    
</div>
</div>
    </form>


</div>

@section('purchaseItem')
    <script>
// select2
$(document).ready(function(){
    $("#productSelect").select2(
      {
        theme:'bootstrap-5',
       
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
    $("#disPer").blur(function(){
    if( $(this).val().length === 0){
        $("#DiscountA").prop('disabled', false);
    }else{
        $("#DiscountA").prop('disabled', true);
    }
  });

  $('body').on('click','.dltItem',function(){
    var dlt_id = $(this).attr('id');
    $.ajax ( {
                        type:"DELETE",
                        url:"/purchaseItem/delete/"+dlt_id,
                        data: {
                            "_token":$('input[name="_token"]').val(),//passing token for deleting
                            "id":dlt_id,
                        },
                        success: function(data) {
                            location.reload();
                        }
                    })
  });

  $("#DiscountA").blur(function(){
    if( $(this).val().length === 0){
        $("#disPer").prop('disabled', false);
    }else{
        $("#disPer").prop('disabled', true);
    }
  });

  $('.purchaseItemTable').DataTable({
    "paging": false,
    "bPaginate": false,
  });
  $('body').on('click','.purchaseItemE',function(){//button press event, showcustomermodel is icon's class
        var id = $(this).attr('id');    
        $('#purchaseItemEdit').modal('toggle');   //showDetails is id of model
        $.get("/purchaseItem/editData/"+id,function(data){
            console.log(data);
            $('#selectProduct').val(data.prod_id);
            $("#selectProduct").select2(
                        {
                            theme:'bootstrap-5',
                            dropdownParent:$('#purchaseItemEdit')
                        }
                    ).trigger('change'); 
            
            $('#pIid').val(data.id);
            
            $('#pIquantity').val(data.quantity);
            $('#pIrate').val(data.rate);
            $('#pIdiscount_percent').val(data.discount_percent);
            $('#pIdiscount_amount').val(data.discount_amount);
       });
             
    });
   
});
// model

  
  
</script>
@endsection


  

@endsection