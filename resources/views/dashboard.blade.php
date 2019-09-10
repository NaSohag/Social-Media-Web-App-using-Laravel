@extends('layouts.master')

@section('title')
    Welcome to Laravel!
@endsection


@section('content')
	<h3>Choose person to talk...</h3>

	@if(count($users)>0)
		@foreach($users as $user)
			<div class="users">
				<ul>
					<li><a href="{{ route('chatting',['op_user_id'=>$user->id]) }}">
						{{ $user->name }}</a></li>
				</ul>
			</div>
		@endforeach
	@endif

	<br>
	<div class="row">
		<div class="col-md-6">
			<form action="{{ route('post.create') }}" method="post">
				<div class="form-group">
					<textarea name="body" class="form-control" rows="5" placeholder="Write post here..."></textarea>
				</div>
				<button type="submit" class="btn btn-primary float-right">Post</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
		</div>
	</div>

	
	<hr>
	@if(count($posts)>0)
	<div class="row">
		<div class="col-md-6">
			@foreach($posts as $post)
			<article class="single-post" data-postid="{{ $post->id }}">
				<p>{{ $post->body }}</p>
				<small>posted by {{ $post->user->name }} on {{ $post->user->created_at }}</small>
				<div class="post-btns">
					<a href="#" class="like-dislike-btn">
					  {{ Auth::user()->likes()->where('post_id',$post->id)->first() ?
					  Auth::user()->likes()->where('post_id',$post->id)->first()->like_status==1 ?
						'You Liked':'Like':'Like'}}
					</a>
					|
					<a href="#" class="like-dislike-btn">
					  {{ Auth::user()->likes()->where('post_id',$post->id)->first() ?
					  Auth::user()->likes()->where('post_id',$post->id)->first()->like_status==0 ?
						'You Disliked':'Dislike':'Dislike'}}
					</a>
					| <a href="#" class="comment-btn">Comment</a>
					@if($post->user->id == Auth::user()->id)
						| <a href="#" class="edit-btn">Edit</a> |
						<a href="{{ route('post.delete',['post_id'=>$post->id]) }}">Delete</a>
					@endif
				</div>
				
				@if(count($post->comments)>0)
					<div id="all-comments">
					@foreach($post->comments as $comment)
						<div class="single-comment" data-commentid="{{ $comment->id }}">
							<p>{{ $comment->body }}</p>
							<div>
								<a href="#">Edit</a> |
								<a href="{{ route('comment.delete',['comment_id'=>$comment->id]) }}">Delete</a>
							</div>
						</div>
					@endforeach
					</div>
				@endif
				
			</article>
			<hr>
			@endforeach
		</div>
	</div>
	@endif


	<div class="modal edit-modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit your Post</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
        	<textarea class="form-control" rows="5" id="modal-body_textarea"></textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="edit-submit">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>


	<div class="modal comment-modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Write a comment</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <textarea id="comment-textarea" class="form-control" rows="5"></textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" id="comment-submit">Save changes</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('post.edit') }}';
		var urlLike = '{{ route('post.like.dislike') }}';
		var urlComment = '{{ route('comment.create') }}';
	</script>
	
@endsection