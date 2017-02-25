<?php

namespace App\Http\Controllers;

use App\User;

class AuthController extends Controller
{
    //
    public function create(){
  		return view('auth.login');
	}

	/* login method */


	public function store(){
		
		
		if(!auth()->attempt(request(['email','password']))){
			return back()->withErrors([
				'message' => 'please check your credentials and try again.'
				]);
		}

		return redirect('/dash');
	}

	/* logout method*/
	public function destroy(){
		auth()->logout();
		return redirect('/');
	}

	public function register(){

		$validator = \Validator::make(request()->all(),
			['name' => 'required',
			 'email'=> 'required|email',
			 'password' => 'required|confirmed'
			]);

		if($validator->fails()){
			return redirect('/#register')
			->withErrors($validator)
			->withInput();
		}
		

		$user = User::create([
			'name' => request('name'),
			'email' => request('email'),
			'password' => bcrypt(request('password'))
			]);

		auth()->login($user);
	}
}
