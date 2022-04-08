@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="">
        <div class=" mt-3" style="float:right">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                {{-- service Invoice --}}
                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{ route('order.serviceItem',['id'=>$order->id]) }}">
                        <button type="button" id="pdfs" class="btn btn btn-danger" style="font-size:19px;"><i
                                class="fa-solid fa-file-pdf"></i>&#160Service Charge</button></a>
                    &#160; &#160;
                    {{-- pdf --}}
                    <a href="{{ route('order.downloadPdf',['id' =>$order->id]) }}">
                        <button type="button" id="pdfs" class="btn btn btn-danger" style="font-size:19px;"><i
                                class="fa-solid fa-file-pdf"></i>&#160PDF</button></a>
                    &#160; &#160;
                    {{-- printing --}}
                    <button type="button" class="btn btn btn-secondary" onclick="printDiv('printableArea')" style="font-size:19px;"><i
                        class="fa-solid fa-print"></i>&#160Print</button>
                    &#160; &#160;
                    
                </div>
    
            </div>
    
        </div>
         </div>
    <div id="printableArea">
        <center>
            <p style="font-size:45px;font-weight:bold;margin-left:5%;margin-bottom:0%; padding:0%">{{$setting->name}}
                </p>
            <p style="font-size:30px;margin:0%; padding:0%;">{{$setting->address}}</p>
            <p style="font-size:22px; padding:0%;">Contact No : <span>{{$setting->contact_number}}</span> ,
                Email : <span>{{$setting->email}}</span></p>
            <p style="font-size:25px; font-weight:bold;margin:0%; padding:0%;">ORDER DIRECT #
                {{$order->invoice_number}}</p>
        </center>
        <p class="test"><span>Name : {{$order->name}}</span>Invoice No : {{$order->invoice_number}}</p>
        <p class="test"><span>Address : {{$order->address}}</span>Transaction Date : {{$order->transaction_date}}</p>


        <hr style="border-style: dashed none;">
        <table class="table stockTable" width="100%">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>PRODUCT NAME</th>
                    <th>UNIT</th>
                    <th>RATE</th>
                    <th>AMOUNT</th>
                    <th>DISCOUNT AMOUNT</th>
                    <th>DISCOUNT(%)</th>
                </tr>
            </thead>
            <tbody>
                @php $i=0 ; @endphp
                @foreach ($order_items as $row)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->unit}}</td>
                    <td>{{$row->rate}}</td>
                    <td>{{$row->amount}}</td>
                    <td>{{$row->discount_percent}}</td>
                    <td>{{$row->discount_amount}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr style="border-style: dashed none;">
        <div class="amount">
            <table >
                <tr>
                    <td style="font-size:19px;font-weight:bold;">SUB AMOUNT : </td>
                    <td style="font-size:19px;font-weight:bold;">
                        @if ($order->total_amount == 0)
                        0
                        @else
                        Rs. {{$order->total_amount}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-size:19px;font-weight:bold;">DISCOUNT AMOUNT : </td>
                    <td style="font-size:19px;font-weight:bold;">
                        @if ($order->discount_amount == 0)
                        0
                        @else
                        Rs. {{$order->discount_amount}}
                        @endif
                    </td>
                </tr>
                {{-- <tr>
                    <td style="font-size:19px;font-weight:bold;">ROUNDING : </td>
                    <td style="font-size:19px;font-weight:bold;">
                        @if ($order->rounding == 0)
                        0
                        @else
                        Rs. {{$order->rounding}}
                        @endif
                    </td>
                </tr> --}}

                <tr>
                    <td style="font-size:19px;font-weight:bold;">ADVANCE PAYMENT : </td>
                    <td style="font-size:19px;font-weight:bold;">
                        @if ($order->advance_payment == 0)
                        0
                        @else
                        Rs. {{$order->advance_payment}}
                        @endif
                    </td>
                </tr>
                
                <tr>
                    
                    <td style="font-size:19px;font-weight:bold;">NET AMOUNT : </td>
                    <td style="font-size:25px;font-weight:bold;">
                        @if ($order->discount_amount == 0 && $order->total_amount == 0)
                        0
                        @else
                        Rs. {{$order->net_amount}}
                        @endif
                    </td>
                </tr>
            </table>
        

        </div>
        <hr style="border-style: dashed none; margin-top:260px;">
        <p style="float:right">PRINTED BY : {{ strtoupper( Auth::user()->name)  }}</p>
    </div>

    </div>
   @section('printLayout')
   <script>
       
        function printDiv(divName) {

                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                
                document.body.innerHTML = printContents;
                
                window.print();
                
                document.body.innerHTML = originalContents;
    }
       
   </script>
   @endsection

@endsection