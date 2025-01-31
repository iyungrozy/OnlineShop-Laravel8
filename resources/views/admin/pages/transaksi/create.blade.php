@extends('layouts.main2')
@section('title', 'Buat Transaksi Baru')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-4 mx-auto">
            <form method="POST" action="{{ route('admin.transaksi.store') }}">
                @csrf
                <div class="card">
                    <div class="card-header bg-success-darker pb-1">
                        <h5 class="text-light"><span class="oi oi-cart"></span> Form Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group form-label-group">
                            <label for="produk">Produk</label>
                            <select class="form-control {{ $errors->has('masakan') ? 'is-invalid' : '' }}" name="masakan">
                                <option value="">Pilih Produk</option>
                                <!-- Loop through Produk -->
                                @foreach($masakan as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_masakan }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('masakan'))
                            <div class="invalid-feedback">{{ $errors->first('masakan') }}</div>
                            @endif
                        </div>

                        <div class="form-group form-label-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control {{ $errors->has('jumlah') ? 'is-invalid' : '' }}" placeholder="Masukkan jumlah" required>
                            @if($errors->has('jumlah'))
                            <div class="invalid-feedback">{{ $errors->first('jumlah') }}</div>
                            @endif
                        </div>

                        <div class="form-group form-label-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}" placeholder="Tambahkan keterangan jika perlu"></textarea>
                            @if($errors->has('keterangan'))
                            <div class="invalid-feedback">{{ $errors->first('keterangan') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><span class="oi oi-check"></span> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

