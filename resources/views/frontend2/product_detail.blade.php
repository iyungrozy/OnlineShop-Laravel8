<!-- resources/views/product_detail.blade.php -->
@extends('layouts.main2')

@section('title', 'Detail Produk')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ url('storage/app/public/gambar/'.$product->gambar) }}" class="img-fluid" alt="{{ $product->nama_masakan }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->nama_masakan }}</h2>
            <p>Kode : {{ $product->kode_masakan }}</p>
            <p>Kategori: {{ $product->nama_kategori }}</p>
            <p>Status: @if($product->status_masakan == 'Ada') <span class="badge badge-success">Ada</span> @else <span class="badge badge-danger">Habis</span> @endif</p>
            <p>Harga: Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
            @if(Auth::check())
                <a href="{{ route('add.cart', ['id' => $product->id]) }}" class="btn btn-success"><span class="oi oi-cart"></span> Pesan</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Pesan</a>
            @endif
        </div>
    </div>
</div>
@endsection