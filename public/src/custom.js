var postId = 0;
var bodyElement = null;
var postRoot = null;
$('.edit-btn').on('click',function(event){
	event.preventDefault();

	postRoot = event.target.parentNode.parentNode;
	bodyElement = postRoot.childNodes[1];
    postId = postRoot.dataset['postid'];


	$('#modal-body_textarea').val(bodyElement.textContent);
	$('.edit-modal').modal();
});	

$('#edit-submit').on('click',function(){

	$.ajax({
		method: 'POST',
		url: urlEdit,
		data: { postId: postId, _token: token ,  body: $('#modal-body_textarea').val()}
	})

	.done(function(msg){
		$('.edit-modal').modal('hide');
		$(bodyElement).text(msg['new_body']);
	});
});
//--------------- upper editor using modal
//--------------- below like-dislike

$('.like-dislike-btn').on('click',function(event){
	event.preventDefault();

	var like_or_dis = event.target.previousElementSibling == null ? 1 : 0;

	var likeBtn,dislikeBtn;
	if(like_or_dis==1){
		likeBtn = event.target;
		dislikeBtn = event.target.nextElementSibling;
	}else{
		likeBtn = event.target.previousElementSibling;
		dislikeBtn = event.target;
	}

	var postRoot = event.target.parentNode.parentNode;
	postId = postRoot.dataset['postid'];

	$.ajax({
		method: 'POST',
		url: urlLike,
		data: {like_or_dis: like_or_dis, _token: token, postId: postId}
	})
	.done(function(msg){
		//alert(msg['isRemoved']);
		if(msg['isRemoved']=='true')
		{
			likeBtn.innerText = 'Like';
			dislikeBtn.innerText = 'Dislike';
		}
		else if(like_or_dis == 1)
		{
			likeBtn.innerText = 'You Liked';
			dislikeBtn.innerText = 'Dislike';
		}
		else if(like_or_dis == 0)
		{
			likeBtn.innerText = 'Like';
			dislikeBtn.innerText = 'You Disliked'
		}
	});
});

//------------------ upper like-dislike
//------------------ below comment
$('.comment-btn').on('click',function(event){
	event.preventDefault();

	postRoot = event.target.parentNode.parentNode;
	postId = postRoot.dataset['postid'];

	$('.comment-modal').modal();
});
$('#comment-submit').on('click',function(){
	$.ajax({
		method: 'POST',
		url: urlComment,
		data: {body: $('#comment-textarea').val(), _token: token, postId: postId}
	})
	.done(function(msg){
		$('.comment-modal').modal('hide');
		//$('#all-comments').html('<div class="single-comment" data-commentid="{{ $comment->id }}"><p>{{ $comment->body }}</p><div><a href="#">Edit</a> | <a href="#">Delete</a></div></div>');
	});
})
