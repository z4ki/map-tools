<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Plan;

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

public function storePlan(Request $request){
	

	if($request->ajax()){
			 $data =  $request->all();

			Plan::create([
				'project_id' => 2,
				'user_id' => auth()->id(),
				'plan' => json_encode($data)
				]);

		return response()->json($data);
		
	}

}
public function showProjects(Request $request){
	


	if($request->ajax()){
	$plans = Plan::all();
	
	
	/*dd($plans->plan);*/
	/*return view('projects',compact('plans'));*/
	return response()->json($plans);
		
	}
}


public function showMap($id,Request $request){

	
	$plan = Plan::where("id", $id)->get();

	if($request->ajax()){
		return response()->json($plan);


	}else{

		return view('dashboard');
		
	}
			
}



}



