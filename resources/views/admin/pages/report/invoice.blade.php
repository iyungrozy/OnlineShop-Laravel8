<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>

    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm 
    ';
    ?>
    <?php 
    $style .= 
        ! empty($_COOKIE['innerHeight'])
            ? $_COOKIE['innerHeight'] .'mm; }'
            : '}';
    ?>
    <?php
    $style .= '
            html, body {
                width: 70mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>

    {!! $style !!}
</head>
<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">A&A Stores</h3>
        <p>Sidoarjo</p>
    </div>
    <br>
    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: right">{{ strtoupper(auth()->user()->fullname) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>No: @foreach($orders as $order) {{$order->kode_order}} @endforeach</p>
    <p class="text-center">===================================</p>
    
    <br>
    <table width="100%" style="border: 0;">
	
	@foreach($order->cart->items as $item)
            <tr>
                <td colspan="3">{{$item['item']['nama_masakan']}}</td>
            </tr>
            <tr>
                <td>{{$item['qty']}} x Rp.{{number_format($item['item']['harga']),0,',','.'}}</td>
                <td></td>
                <td class="text-right">Rp.{{number_format($item['harga']),0,',','.'}}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">@foreach($orders as $order)Rp.{{number_format($order->subtotal),0,',','.'}}</td>@endforeach
			</td>
        </tr>
        <tr>
		<td>Total Item:</td>
<td class="text-right">
    @php
        $totalQty = 0;
    @endphp
    @foreach($order->cart->items as $item)
        @php
            $totalQty += $item['qty'];
        @endphp
    @endforeach
    {{$totalQty}}
</td>
        </tr>
        <tr>
            <td>Total Bayar:</td>
            <td class="text-right">@foreach($orders as $order)Rp.{{number_format($order->subtotal),0,',','.'}}</td>@endforeach
        </tr>
    </table>

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
                body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight
            );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight="+ ((height + 50) * 0.264583);
    </script>
</body>
</html>

