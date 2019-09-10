<?php
namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Like;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
	public function dashboardView()
	{
		$users = User::where('id','<>',Auth::user()->id)->get();
		$posts = Post::orderBy('created_at','desc')->get();
		return view('dashboard')->with(['users'=>$users,'posts'=>$posts]);
	}

	public function createPost(Request $request)
	{
		$this->validate($request,[
			'body' => 'required|max:500'
		]);

		$post = new Post();
		$post->body = $request['body'];
		$post->user_id = Auth::user()->id;

		$post->save();
		return redirect()->back()->with(['message'=>'Successfully Posted']);
	}

	public function editPost(Request $request)
	{
		$this->validate($request,[
			'body' => 'required|max:500'
		]);

		$post = Post::find($request['postId']);
		$post->body = $request['body'];

		if($post->user == Auth::user()){
			$post->update();
			return response()->json(['new_body'=>$post->body],200);
		}
	}

	public function deletePost($post_id)
	{
		$post = Post::find($post_id);

		if($post->user == Auth::user()){
			$post->delete();
		}

		return redirect()->back();
	}

	public function postLikeDislike(Request $request)
	{
		$post_id = $request['postId'];
		$user = Auth::user();
		$like_or_dis = $request['like_or_dis'];

		$isRemoved = 'false';


		$like = $user->likes()->where(['post_id'=>$post_id])->first();

		if($like)
		{
			if($like_or_dis == $like->like_status)
			{
				$like->delete();
				$isRemoved = 'true';
			}
			else
			{
				$like->like_status = $like_or_dis;
				$like->update();
			}
		}
		else
		{
			$like = new Like();
			$like->user_id = $user->id;
			$like->post_id = $post_id;
			$like->like_status = $like_or_dis;
			$like->save();
		}

		return response()->json(['isRemoved'=>$isRemoved],200);
	}

	public function createComment(Request $request)
	{
		$this->validate($request,[
			'body' => 'required|max:500'
		]);

		$comment = new Comment();
		$comment->body = $request['body'];
		$comment->post_id = $request['postId'];
		$comment->user_id = Auth::user()->id;
		$comment->save();


		return response()->json(['commentId'=>$comment->id]);
	}

	public function deleteComment($comment_id)
	{
		$comment = Comment::find($comment_id);
		$comment->delete();
		return redirect()->back();
	}
}

