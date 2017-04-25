<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\User;
class MapController extends AuthController
{
    //
		/* Store Map that made by a user*/

    public function storeMap(Request $request){
	

	if($request->ajax()){
		
		

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
	

}

}
	/* Show user  projects*/

public function showProjects(Request $request){
	


	if($request->ajax()){
		$map = Map::where('user_id',auth()->user()->id)->get();
	
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

public function search($string){
	
		if(auth()->user()->type == 'manager' || auth()->user()->type == 'admin'){
			/*$users = User::where('supervisor_id',auth()->user()->id)->get();
			dd($users);*/
			$projectName =  Map::where("project_name" ,'like',  $string . '%')
						->where('user_id',auth()->user()->id)
						->get();
		
			return response()->json($projectName);
		}else{
			$projectName =  Map::where("project_name" ,'like', '%' . $string . '%')
						->where('user_id',auth()->user()->id)
						->get();
		
			return response()->json($projectName);
		}
	
}


}
