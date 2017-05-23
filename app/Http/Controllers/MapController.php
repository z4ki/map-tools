<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\User;
use App\Manager;
use App\Agent;

class MapController extends AuthController
{
    //
		/* Store Map that made by a user*/

    public function storeMap(Request $request){
	

	if($request->ajax()){
		
		

			// $data =  $request->except(['projectName','description','state','screenshot']);
			$img = str_replace('data:image/jpeg;base64,', '', $request->screenshot);
			$img = str_replace(' ', '+', $img);
			$photo = base64_decode($img);
			 
			$filename = time() . '.' . 'jpeg';
			
			$path = public_path() . "\storage\mapScreenshot\\" . $filename;

			 file_put_contents($path, $photo);
			
			
			


			Map::create([
				'user_id' => auth()->id(),
				'map' => json_encode($request->except(['projectName','description','state','screenshot'])),
				'project_name' => $request->projectName,
				'description'  => $request->description,
				'state' =>$request->state,
				'screenshot' =>$filename
				]);
			// dd($data);

		return response()->json("Saved!!");
	

}

}
//  Show the manager sub agents projects

public function showSubProjects(Request $request){
	$man = Manager::where('user_id',auth()->id())->get()->first();
	 		$i = 0;
			$projects  = new \Illuminate\Database\Eloquent\Collection;
		 	foreach($man->myAgents as $agent){
		 		// $users[$i] = User::find($agent->user_id);
				$map[$i] = \App\Map::where('user_id',$agent->user_id)->get();
				if($map[$i]->isNotEmpty()){
		 		$projects = $projects->merge($map[$i]);
				}
				$i++;
		 		
		 	}
		 	$map[$i] = Map::where('user_id',auth()->id())->get();
		 	if($map[$i]->isNotEmpty()){
		 		$projects = $projects->merge($map[$i]);
				}
			return response()->json($projects);

}

	/* Show user  projects*/
public function showProjects(Request $request){
	


	// if($request->ajax()){
	
		$maps = Map::where('user_id',auth()->user()->id)->paginate(10);
		return view('projects',compact('maps'));
		// return response()->json($map);
	// }
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
						->orWhere("description",'like','%' . $string .'%')
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



public function deleteMap(Request $request,$id){
	if($request->ajax() && $request->isMethod('post')){
		Map::find($id)->delete();
		return response()->json('deleted');
	}
}


public function getPublicMaps(Request $request){
	

		$maps = Map::where('state','Public')->paginate(6);
		
		
		return view('maps',compact('maps'));

	
}

public function getMap(Request $request,$id){
		if($request->ajax()){
			$map  = Map::where('id',$id)
				->where('state', 'Public')->get();

			return response()->json($map);

		}else{
			return view('showMap');
		}
	}


}
