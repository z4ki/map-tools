<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
class MapController extends Controller
{
    //
		/* Store Map that made by a user*/

    public function storeMap(Request $request){
	

	if($request->ajax()){
			 $data =  $request->all();

			Map::create([
				'user_id' => auth()->id(),
				'map' => json_encode($data)
				]);

		return response()->json($data);
		
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
