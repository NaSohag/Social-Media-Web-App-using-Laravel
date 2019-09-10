@if(count($errors)>0)
<div class="row">
	<div class="col-md-6 error-message">
		<ul>
			@foreach($errors->all() as $err)
			<li>
				{{ $err }}
			</li>
			@endforeach
		</ul>
	</div>
</div>
@endif


@if(Session::has('message'))
<div class="row">
	<div class="col-md-6 success-message">
		{{ Session::get('message') }}
	</div>
</div>
@endif