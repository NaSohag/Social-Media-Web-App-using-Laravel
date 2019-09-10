<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
	public function register(Request $request)
	{
		$this->validate($request,[
			'email' => 'required|email|unique:users',
			'name' => 'required',
			'password' => 'required|min:4'
		]);

		$user = new User();
		$user->email = $request['email'];
		$user->name = $request['name'];
		$user->password = bcrypt($request['password']);

		$user->save();

		Auth::login($user);

		return redirect()->route('dashboard')->with(['message'=>'Successfully Registered']);
	}

	public function logIn(Request $request)
	{
		$this->validate($request,[
			'email' => 'required|email',
			'password' => 'required'
		]);


		if(Auth::attempt(['email'=> $request['email'], 'password'=>$request['password']]))
		{
			return redirect()->route('dashboard')->with(['message'=>'Successfully logged in']);
		}

		return redirect()->route('root');
	}

	public function logOut()
	{
		Auth::logout();

		return redirect()->route('root');
	}

	public function userAccount()
	{
		$user = Auth::user();
		return view('account')->with(['user'=>$user]);
	}

	public function updateAccount(Request $request)
	{
		$this->validate($request,[
			'name' => 'required|max:100'
		]);
		$user = Auth::user();
		$img_url = md5($user->id).uniqid().'.jpg';
		//$img_url = 'hello.jpg';

		$img_file = $request->file('img-upload');

		if($img_file){
			Storage::disk('local')->put($img_url,File::get($img_file));
			$user->img_url = $img_url;
		}

		$user->name = $request['name'];
		$user->update();

		return redirect()->back()->with(['message'=>'Successfully Updated']);
	}

	public function getImage($img_url)
	{
		$file = Storage::disk('local')->get($img_url);
		return new Response($file,200);
	}
}