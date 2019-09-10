@extends('layouts.master')

@section('title')
	Hey Buddy !!!
@endsection

@section('content')

	<div class="row">


		<div class="col-md-3">
			<br><br>
			<h3>Choose person to talk...</h3>

			@if(count($users)>0)
				@foreach($users as $user)
					<div class="users">
						<ul>
							<li class="person-list {{ $op_user->id == $user->id ? 'current-opposite': '' }}">
								<a href="{{ route('chatting',['op_user_id'=>$user->id]) }}">
								{{ $user->name }}</a>
							</li>
						</ul>
					</div>
				@endforeach
			@endif
		</div>


		<div class="col-md-6 col-md-offset-3">
			<div class="chatting-area">

				<div class="chatting-header">
					<div class="opposite">
						<h4>{{ $op_user->name }}</h4>
					</div>
					<div class="myself">
						<h4><small>myself: </small>{{ Auth::user()->name }}</h4>
					</div>
				</div>
				

				<hr>
				@if(count($chats)>0)
				<div class="show-msg"> 
					@foreach($chats as $chat)
						@if(Auth::user()->id == $chat->rcvr_id)
							<div class="msg-left">
								{{ $chat->body }}
							</div>
						@else
							<div class="msg-right">
								{{ $chat->body }}
							</div>
						@endif
						<br>
					@endforeach
				</div>
				@endif


				<form action="{{ route('send.msg') }}" method="post" class="form-parent">
					<input class="form-control msg-body" type="text" name="msg-body">
					<input type="hidden" name="rcvr_id" value="{{ $op_user->id }}">
					<button type="submit" class="btn btn-primary msg-snd-btn">Send</button>
					<input type="hidden" name="_token" value="{{ Session::token() }}">
				</form>


			</div>
		</div>
	</div>
@endsection