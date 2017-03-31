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
	    $this->middleware('auth');
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
		return redirect('/');
	}



		/* Update User Profile */

	public function updateProfile(Request $request){

		if($request->hasFile('avatar')){
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $request->avatar->extension();
			$request->avatar->storeAs('public/avatars/',"$filename");
			
			$user = Auth::user();
			$user->avatar = $filename;
			$user->save();
			$url = Storage::url('avatars/ ' . $filename);
			$img = "<img src='". $url . "'/>";
			return $img;
			
		}
	}

	/* Add new Agent or Manager */

	public function registerNewAgent(Request $request){
		

		
		
			if($request->ajax()){

				$result = $this->validateCaptcha($request->captcha);

				if($result['success'] == 1){
        
						$validator = \Validator::make($request->all(),
							['first_name' => 'required',
							 'email'=> 'required|email',
							 'password' => 'required|confirmed',
							 'type' => 'required'
							]);

						if($validator->fails()){
							/*dd($validator);*/
							/*return redirect('/addAgent')
							->withErrors($validator)
							->withInput();*/
							return response()->json("Please check you inputs again!!");
						}
						if(auth()->user()->type == 'admin'){
							$type = $request->type;
						}else if(auth()->user()->type == 'manager'){

							$type = 'agent';
						}

						
				
					$user = User::create([
						'first_name' => $request->first_name,
						'last_name' => $request->last_name,
						'email' => $request->email,
						'password' => bcrypt($request->password),
						'type' => $type,
						'supervisor_id' => auth()->id()
						]);

					$msg = "New " . $type ." has been added!";
					return response()->json($msg);
			    }else{
			    	return response()->json('reCaptcha');
			    }
		}

		}




	/* Validate reCaptcha */
	 public function validateCaptcha($response){
		$secret = '6LeCvBkUAAAAAK3pv_ifzDgH2-gbwnGdLrkuV1IE';
		$url = file_get_contents(
			"https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response"
			);
		$result = json_decode($url,TRUE);
		return $result;
	 }


}



