<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChattingController extends Controller
{
	public function index($op_user_id)
	{
		$op_user = User::find($op_user_id);

		$users = User::where('id','<>',Auth::user()->id)->get();

		$op_id = $op_user_id;
		$auth_id = Auth::user()->id;

		$chats = Chat::whereIn('sndr_id',[$auth_id,$op_id])
						->whereIn('rcvr_id',[$auth_id,$op_id])
						->get();

		return view('chatting')->with(['op_user'=>$op_user,'chats'=>$chats,'users'=>$users]);
	}

	public function sendMessage(Request $request)
	{
		$this->validate($request,[
			'msg-body' => 'required'
		]);
		
		$chat = new Chat();
		$chat->body = $request['msg-body'];
		$chat->rcvr_id = $request['rcvr_id'];
		$chat->sndr_id = Auth::user()->id;
		$chat->seen_status = false;
		$chat->save();

		return redirect()->back()->with(['message'=>$request['msg-body']]);
	}
}