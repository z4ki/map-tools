
<?php


Route::get('/', function () {
    return view('index');
});
Route::get('/dash',function(){
  return view('dashboard');
});
Route::post('/dash/store','AuthController@storePlan');


Route::get('/projects',function(){
	return view('projects');
});
Route::get('/projects/show','AuthController@showProjects');

Route::get('/projects/show/{id}','AuthController@showMap');



Route::get('/login','AuthController@create');

Route::get('/register',function(){
  return view('auth.register');
});

Route::post('/login' ,'AuthController@store');
Route::get('/logout','AuthController@destroy');


Route::post('/register' ,'AuthController@register');