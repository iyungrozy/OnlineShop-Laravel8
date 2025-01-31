@extends('layouts.report')
@section('your Delivery')
@section('content')

<div class="row contacts">
	    <div class="col invoice-to">
	        <div class="text-gray-light">Invoice Untuk:</div>
	        <h2 class="to">{{Auth::user()->fullname}}</h2>
	    </div>
	    <div class="col invoice-details">
	    	@foreach($orders as $order)
	        <h1 class="invoice-id">{{$order->kode_order}}</h1>
	        <div class="date">Invoice Pada Tanggal : {{date('d F Y - H:i',strtotime($order->created_at))}}</div>
	        @endforeach
	    </div>
	</div>

   	@foreach($orders as $order)
	   @if(Auth::check() && Auth::user() && (Auth::user()->level == 'admin' || Auth::user()->level == 'admin'))
	  <a href="{{route('invoice', ['kode_order' => $order->kode_order])}}" class="btn btn-success btn-sm" target="_blank"><span class="oi oi-print"> Cetak Struk Sebagai Admin</span></a>
		@else
	<h2>Nomer Antrian	: {{$order->no_meja}}</h2>
    <hr>
    <h2>Kode Delivery	: {{$order->kode_order}}</h2>
    <hr>
    <h2>Menunggu Pembayaran</h2>
	<div class="notices">
	    <div>NOTICE:</div>
	    <div class="notice">Silahkan Melakukan Pembayaran</div>
	</div>
		@endif
    @endforeach
    <br>
	
	
	


@endsection

