@extends('layouts.master')

@section('title')
	Hey buddy!
@endsection

@section('content')
	<div class="row">
		<div class="col-md-6">
			<form action="{{ route('account.update') }}" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" name="name" class="form-control" value="{{ $user->name }}">
					<input type="file" name="img-upload" class="form-control">
					<button type="submit" class="btn btn-primary">Save Change</button>
					<input type="hidden" name="_token" value="{{ Session::token() }}">
				</div>
				
			</form>
		</div>
	</div>

	@if(Storage::has($user->img_url))
	<div class="row">
		<div class="col-md-6">
			<img src="{{ route('get.image',['img_url'=>$user->img_url]) }}" alt="">
		</div>
	</div>
	@endif

@endsection