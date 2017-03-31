<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
class MapController extends AuthController
{
    //
		/* Store Map that made by a user*/

    public function storeMap(Request $request){
	

	if($request->ajax()){
		$result = $this->validateCaptcha($request->captcha);
		if($result['success'] == 1){

			$data =  $request->all();
			
			/*$data->rectangles = $request->rectangles;
			data*/
			


			Map::create([
				'user_id' => auth()->id(),
				'map' => json_encode($data),
				'project_name' => $request->projectName,
				'description'  => $request->description
				]);

		return response()->json("Saved!!");
	}else {
		return response()->json('reCaptcha wrong');

			}

}

}
	/* Show user  projects*/

public function showProjects(Request $request){
	


	if($request->ajax()){
		$map = Map::all();
	
	return response()->json($map);
		
	}
}
	/*Show the Selected Map*/
public function showMap($id,Request $request){

	
	$map = Map::where("id", $id)->get();

	if($request->ajax()){
		return response()->json($map);


	}else{

		return view('dashboard');
		
	}
			
}


}
