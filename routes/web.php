
<?php


Route::get('/', function () {
    return view('index');
});
Route::get('/dash',function(){
  return view('dashboard');
})->middleware('auth');

Route::get('/addAgent',function(){
  return view('addAgent');
})->middleware('auth');

Route::post('/settings','AuthController@updateProfile');
Route::get('/settings',function(){
	return view('profile-settings');
});

Route::post('/dash/store','MapController@storeMap');


Route::get('/projects',function(){
	return view('projects');
});
Route::get('/projects/show','MapController@showProjects');

Route::get('/projects/show/{id}','MapController@showMap');



Route::get('/login','AuthController@create')->name('login');

Route::get('/register',function(){
  return view('auth.register');
});

Route::post('/login' ,'AuthController@store');
Route::get('/logout','AuthController@destroy');


Route::post('/register' ,'AuthController@registerNewAgent');


Route::get('/admin','AuthController@addAdmin');