@extends('admin.main2')
@section('title','Tambah Data Produk')

@section('content')

	<div class="container-fluid">

		@if(session('result') == 'success')
		<div class="alert alert-success data-dismissible" role="alert">
		  <h4 class="alert-heading">Berhasil!</h4>Data Berhasil Disimpan ke Database.
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		
		@elseif(session('result') == 'fail')
		<div class="alert alert-danger data-dismissible" role="alert">
		  <h4 class="alert-heading">Ups!</h4>Ada Kesalahan, Check Kembali Data Dibawah.
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		@endif

		<form method="POST" action="{{ route('admin.masakan.add') }}" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header bg-primary pb-1">
		        	<h5 class="text-light"><span  class="oi oi-plus"></span> Tambah Item Produk</h5>
		   		</div>
				<div class="card-body">

					<div class="form-group form-label-group">
						<label for="iNamaProduk">Nama Produk</label>
						<input type="text" name="nama_masakan"
						class="form-control {{ $errors->has('nama_masakan')?'is-invalid':'' }} "
						value="{{ old('nama_masakan') }}"
						id="iNamaProduk" placeholder="Nama Produk" required>
						@if($errors->has('nama_masakan'))
						<div class="invalid-feedback">{{ $errors->first('nama_masakan') }}</div>
						@endif
					</div><!--End Form Group-->

					<div class="form-group form-label-group">
						<label for="iKategori">Kategori</label>
						<select name="kategori_id" class="form-control {{ $errors->has('kategori_id')?'is-invalid':'' }}" required autofocus>
							<option value="">Kategori :</option>
							<?php 
								$val = Request::old('kategori_id');
								$res = App\Kategori::orderBy('nama_kategori','asc')->get();
							 ?>

							 @foreach($res as $opt)
							<option value="{{$opt->id}}" {{$val==$opt->id?'selected':''}}>{{$opt->nama_kategori}}</option>
							@endforeach
						</select>
					</div><!--End Form Group-->

					<div class="form-group form-label-group">
						<label for="iGambar">Gambar</label>
						<input type="file" name="gambar"
						class="form-control {{ $errors->has('gambar')?'is-invalid':'' }} "
						accept="image/*" 
						value="{{ old('gambar') }}"
						id="iGambar" placeholder="Gambar Produk" required>
						@if($errors->has('gambar'))
						<div class="invalid-feedback">{{ $errors->first('gambar') }}</div>
						@endif
					</div><!--End Form Group-->

					<div class="form-group form-label-group">
						<label for="iHarga">Harga</label>
						<input type="number" name="harga"
						class="form-control {{ $errors->has('harga')?'is-invalid':'' }} "
						value="{{ old('harga') }}"
						id="iHarga" placeholder="Harga Produk" required>
						@if($errors->has('harga'))
						<div class="invalid-feedback">{{ $errors->first('harga') }}</div>
						@endif
					</div><!--End Form Group-->

					<div class="form-group form-label-group">
						<label for="iStok">Jumlah Stok</label>
						<input type="number" name="stok"
						class="form-control {{ $errors->has('stok')?'is-invalid':'' }} "
						value="{{ old('stok') }}"
						id="iStok" placeholder="Jumlah Stok" required>
						@if($errors->has('stok'))
						<div class="invalid-feedback">{{ $errors->first('stok') }}</div>
						@endif
					</div><!--End Form Group-->

					<div class="form-group form-label-group">
						<label for="">Status Produk</label>
						<select name="status_masakan" class="form-control">
							<option value="">Status Produk :</option>
							<option value="Ada">Ada</option>
							<option value="Habis">Habis</option>
						</select>
					</div><!--End Form Group-->

				</div><!--End Card body-->

				<div class="card-footer">
					<button class="btn btn-primary" type="submit">Simpan</button><!--End Card footer-->
				</div>

			</div><!--End Card-->
		</form>
	</div>

@endsection

@push('js')
<script type="text/javascript">
	function filePreview(input) {
		if(input.files && input.files[0]) {}
			var reader = new FileReader();
			reader.onload = function(e){
				$('#iGambar + img').remove();
				$('#iGambar').after('<img src="'+e.target.result+'" width="100" class="mt-3" />');
			}
			reader.readAsDataURL(input.files[0]);
	}
	$(function() {
		$('#iGambar').change(function(){
			filePreview(this);
		})
	})
</script>
@endpush
@endpush