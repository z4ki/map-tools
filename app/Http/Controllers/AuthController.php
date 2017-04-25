<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Plan;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

	/*public function __construct()
	{
	    $this->middleware('auth')->except(['create']);
	}*/
    // Create An Admin for just the first time 
    
    public function addAdmin(){

    	$admin = new User;
    	$admin->first_name = 'admin';
    	$admin->last_name = 'Zak Rovsky';
    	$admin->email = 'z4ki.xy@gmail.com';
    	$admin->password = bcrypt('mad');
    	$admin->type = 'admin';
    	$admin->supervisor_id =0;
    	$admin->save();
    	
    }

    // Return Login Page
    public function create(){
  		return view('auth.login');
	}

	/* login method */

	/*Login the User*/
	public function store(){
		
		
		if(!auth()->attempt(request(['email','password']))){
			return back()->withErrors([
				'message' => 'please check your credentials and try again.'
				]);
		}

		return redirect()->intended('/dash');
	}





	/* logout method*/
	public function destroy(){
		auth()->logout();
		return redirect()->back();
	}



		/* Update User Profile */

	public function updateProfile(Request $request){

		$user = \Auth::user();
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;

		if($request->password){
			
			$user->password = $request->password;
		}

		if($request->hasFile('avatar')){
			
			$filename = time() . '.' . $request->avatar->extension();
			$request->avatar->storeAs('public/avatars/',"$filename");
			
			$user->avatar = $filename;
			
		}
			$user->save();
			return back();			

		
	}

	/* Add new Agent or Manager */

	public function registerNewAgent(Request $request){
		

		
		
			/*if($request->ajax()){
*/
				/*$result = $this->validateCaptcha($request->captcha);*/

				/*if($result['success'] == 1){*/
        
						$validator = \Validator::make($request->all(),
							['first_name' => 'required',
							 'email'=> 'required|email',
							 'password' => 'required|confirmed',
							 'type' => 'required'
							]);

						if($validator->fails()){
							
							return redirect('/addAgent')
							->withErrors($validator)
							->withInput();
							/*return response()->json($validator);*/
						}
						if(auth()->user()->type == 'admin'){
							$type = $request->type;
						}else if(auth()->user()->type == 'manager'){

							$type = 'agent';
						}
				
				$exist = User::where('email',$request->email)->first();
				
				if($exist != null){
					
					return redirect('/addAgent')
							->withErrors("email already exist!")
							->withInput();
				}else{

					$user = User::create([
						'first_name' => $request->first_name,
						'last_name' => $request->last_name,
						'email' => $request->email,
						'password' => bcrypt($request->password),
						'type' => $type,
						'supervisor_id' => auth()->id()
						]);

					$msg = "New " . $type ." has been added!";
					session()->flash('message', $msg );
					return redirect('/addAgent');
			    /*}else{
			    	return response()->json('reCaptcha');
			    }*/
		/*}*/
				}

		}




	public function showUsers(Request $request){
		if($request->ajax()){
			if(auth()->user()->type == 'admin'){
				$users = User::all();
				return response()->json($users);
			}else{

				$users = User::where('supervisor_id','=' ,auth()->id())->get();
				return response()->json($users);
			}
		}else{
			return view('users');
		}
	}
	 
	 


}



