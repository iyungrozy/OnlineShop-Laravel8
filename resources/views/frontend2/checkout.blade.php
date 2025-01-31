@extends('layouts.main2')
@section('title','Checkout')
@section('content')

<div class="container">

	<div class="row">
		<div class="col-md-6 pt-4 mx-auto">
			<form method="POST" action="{{route('postcheckout')}}">
				@csrf
				<div class="card">
					<div class="card-header bg-success-darker pb-1">
			        	<h5 class="text-light"><span  class="oi oi-cart"></span> Keterangan</h5>
			   		</div>
			   		@if(session('info') == 1)
			   		<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>tidak bisa!</strong> Saat ini, saat ini antrian sedang penuh
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
			   		@endif
					<div class="card-body">
						<!-- <div class="form-group form-label-group">
							<label for="">Nomor Antrian Anda</label>
							<input type="number" min="1" max="50" name="no_meja"
							class="form-control {{ $errors->has('no_meja')?'is-invalid':'' }} "
							value="{{ old('no_meja') }}"
							id="" placeholder="nomor antrian" required autofocus>
							@if($errors->has('no_meja'))
							<div class="invalid-feedback">{{ $errors->first('no_meja') }}</div>
							@endif
							<small class="text-muted">Masukan Nomor Meja yang tertera di Meja Anda.</small>
						</div> --><!--End Form Group-->

						<div class="form-group form-label-group">
							<label for="">Keterangan</label>
							<textarea  name="keterangan"
							class="form-control {{ $errors->has('keterangan')?'is-invalid':'' }} "
							value="{{ old('keterangan') }}"
							id="" placeholder="Ketikan sesuatu..."></textarea>
							@if($errors->has('keterangan'))
							<div class="invalid-feedback">{{ $errors->first('keterangan') }}</div>
							@endif
							<small class="text-muted">ex**: diantar nanti saja.</small>
							<small class="text-muted">| Lewati bila tidak ingin menambah keterangan.</small>
						</div><!--End Form Group-->
						<small class="text-muted"></small>

						<input type="hidden" name="id_user" value="{{Auth::user()->id}}">
						  @if(Auth::check() && Auth::user() && (Auth::user()->level == 'admin' || Auth::user()->level == 'admin'))
						  <input type="hidden" name="status_order" value="Beres">
						<input type="hidden" name="admin_order" value="1">
						@else
 					   <input type="hidden" name="status_order" value="Menunggu Pembayaran">
						@endif
					</div>	

					<div class="card-footer">
						<button class="btn btn-success" type="submit"><span class="oi oi-check"></span> Simpan</button><!--End Card footer-->
					</div>

				</div><!--End Card-->
			</form>
		</div>
	</div>
</div>

@endsection