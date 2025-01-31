@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transaksi Selesai</h2>
    <div class="alert alert-success" role="alert">
        Transaksi dengan ID: {{ $transaksi->id }} telah berhasil diproses.
    </div>
    <div>
        <p><strong>User ID:</strong> {{ $transaksi->user_id }}</p>
        <p><strong>Order ID:</strong> {{ $transaksi->order_id_order }}</p>
        <p><strong>Total Bayar:</strong> Rp{{ number_format($transaksi->total_bayar, 2) }}</p>
        <p><strong>Kembalian:</strong> Rp{{ number_format($transaksi->kembalian, 2) }}</p>
        <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->tanggal_transaksi->format('d M Y') }}</p>
    </div>
    <a href="{{ route('admin.pages.transaksi.create') }}" class="btn btn-primary">Input Transaksi Baru</a>
</div>
@endsection