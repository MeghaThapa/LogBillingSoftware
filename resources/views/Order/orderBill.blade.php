<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Billing</title>
    <style type="text/css">
        .test {
            background: white;
            color: #000000;
            font-size: 22px;
            text-align: right;
            white-space: nowrap;
        }

        .test span {
            float: left;
            width: 5em;
            text-align: left;
        }
        table.stockTable{
        width: 100%;
        border-collapse: collapse;
        }
        table.stockTable th {
        border:2px #000000;
        border-collapse:collapse;
        border-style: dashed dashed;
        }
        .table.stockTable td,.table.stockTable th {
        padding:10px 15px;
        border:2px #000000;
        border-collapse:collapse;
        border-style: dashed none ;
        text-align: center;
        font-size:16px;
        }
        
        .amount{
            float:right ;
        margin-right:50px;
        margin-top: 20px;
        }
        #words{
        margin-left:100px;
        }
    </style>
</head>

<body>

    <div class="container">


        @php
        // $names = strtoupper($config->name);
        @endphp
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
   
    
</body>

</html>