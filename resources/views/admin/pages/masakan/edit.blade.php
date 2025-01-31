@extends('admin.main2')
@section('title','Edit Data Produk')

@section('content')
<div class="container-fluid">

	@if(session('result') == 'success')
	<div class="alert alert-success data-dismissible" role="alert">
	  <h4 class="alert-heading">Terupdate!</h4>Data Berhasil Diupdate.
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
	
	@elseif(session('result') == 'fail')
	<div class="alert alert-danger data-dismissible" role="alert">
	  <h4 class="alert-heading">Ups!</h4>Ada Kesalahan Saat Menginputkan Data, Silahkan Check Kembali.
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
	@endif

	<form method="POST" action="{{ route('admin.masakan.edit', ['id'=>$rc->id]) }}" enctype="multipart/form-data">
		@csrf
		<div class="card">
			<div class="card-header bg-primary pb-1">
	        	<h5 class="text-light"><span  class="oi oi-pencil"></span> Edit Item Produk</h5>
	   		</div>
			<div class="card-body">

				<div class="form-group form-label-group">
					<label for="iNamaProduk">Nama Produk</label>
					<input type="text" name="nama_masakan"
					class="form-control {{ $errors->has('nama_masakan')?'is-invalid':'' }} "
					value="{{ old('nama_masakan',$rc->nama_masakan) }}"
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
							$val = old('kategori_id',$rc->kategori_id);
							$res = App\Kategori::orderBy('nama_kategori','asc')->get();
						 ?>

						 @foreach($res as $opt)
						<option value="{{$opt->id}}" {{$val==$opt->id?'selected':''}}>{{$opt->nama_kategori}}</option>
						@endforeach
					</select>
				</div><!--End Form Group-->

				<div class="form-group form-label-group">
					<img id="ibaru" src="{{url('storage/app/public/gambar/' .$rc->gambar)}}" width="120px" align="middle">
					<input type="file" name="gambar"
					class="form-control {{ $errors->has('gambar')?'is-invalid':'' }}"
					accept="image/*" 
					value="{{ old('gambar', $rc->gambar) }}"
					id="iGambar" placeholder="Gambar Produk">
					@if($errors->has('gambar'))
					<div class="invalid-feedback">{{ $errors->first('gambar') }}</div>
					@endif
					<small>Biarkan jika gambar tidak ingin anda ubah.</small>
				</div><!--End Form Group-->

				 <div class="form-group form-label-group">
					<label for="iHarga">Harga</label>
					<input type="text" name="harga"
					class="form-control {{ $errors->has('harga')?'is-invalid':'' }} "
					value="{{ old('harga',$rc->harga) }}"
					id="iHarga" placeholder="Harga" required>
					@if($errors->has('harga'))
					<div class="invalid-feedback">{{ $errors->first('harga') }}</div>
					@endif
				</div><!--End Form Group -->

				<div class="form-group form-label-group">
					<?php 
						$val = old('status_masakan',$rc->status_masakan);
					 ?>
					 <label for="">Status Produk</label>
					<select name="status_masakan" class="form-control {{ $errors->has('status_masakan')?'is-invalid':'' }}" required>
						<option value="" disabled="" {{ $val==""?'selected':'' }}>Status Produk :</option>
						<option value="Ada" {{ $val=="Ada"?'selected':'' }}>Ada</option>
						<option value="Habis" {{ $val=="Habis"?'selected':'' }}>Habis</option>
					</select>
					@if($errors->has('status_masakan'))
					<div class="invalid-feedback">{{$errors->first('status_masakan')}}</div>
					@endif
				</div><!--End Form Group-->
									<div class="form-group form-label-group">
						<label for="iStok">Jumlah Stok</label>
						<input type="number" name="stok"
						class="form-control {{ $errors->has('stok')?'is-invalid':'' }} "
						value="{{ old('stok',$rc->stokn) }}"
						id="iStok" placeholder="Jumlah Stok" required>
						@if($errors->has('stok'))
						<div class="invalid-feedback">{{ $errors->first('stok') }}</div>
						@endif
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
				$('#ibaru').attr('src', e.target.result)
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