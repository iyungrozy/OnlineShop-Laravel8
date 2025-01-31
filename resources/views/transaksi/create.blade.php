@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Input Transaksi Baru</h2>
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">User ID:</label>
            <input type="text" class="form-control" id="user_id" name="user_id" required>
        </div>
        <div class="form-group">
            <label for="order_id_order">Order ID:</label>
            <input type="text" class="form-control" id="order_id_order" name="order_id_order" required>
        </div>
        <div class="form-group">
            <label for="total_bayar">Total Bayar:</label>
            <input type="number" class="form-control" id="total_bayar" name="total_bayar" required>
        </div>
        <div class="form-group">
            <label for="kembalian">Kembalian:</label>
            <input type="number" class="form-control" id="kembalian" name="kembalian" required>
        </div>
        <div class="form-group">
            <label for="tanggal_transaksi">Tanggal Transaksi:</label>
            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
        </div>
        <div class="form-group">
            <label for="masakan[]">Masakan:</label>
            <input type="text" class="form-control" name="masakan[]" required>
            <button type="button" onclick="addMasakan()">Tambah Masakan</button>
        </div>
        <div id="masakanContainer"></div>

        <script>
        function addMasakan() {
            let container = document.getElementById('masakanContainer');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'masakan[]';
            input.className = 'form-control';
            container.appendChild(input);
        }
        </script>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
@endsection