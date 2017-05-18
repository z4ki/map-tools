
<?php


Route::get('/', function () {

    return view('index');

});
Route::get('/dash',function(){

  return view('dashboard');

})->middleware('auth');
Route::get('/maps','MapController@getPublicMaps');

Route::get('/addAgent',function(){

  return view('addAgent');
})->middleware('auth');

Route::post('/settings','AuthController@updateProfile')->middleware('auth');

Route::get('/settings',function(){

	return view('profile-settings');

})->middleware('auth');

Route::post('/dash/store','MapController@storeMap')->middleware('auth');


Route::get('/projects',function(){

	return view('projects');

})->middleware('auth');

Route::get('/Departement',function(){

	return view('projects');

})->middleware('auth');

Route::get('/projects/show','MapController@showProjects')->middleware('auth');

Route::get('/projects/show/{id}','MapController@showMap')->middleware('auth');



Route::get('/login','AuthController@create')->name('login');


Route::get('/register',function(){

  return view('auth.register');

})->middleware('auth');

Route::post('/login' ,'AuthController@store');
Route::get('/logout','AuthController@destroy')->middleware('auth');


Route::post('/register' ,'AuthController@registerNewAgent')->middleware('auth');


Route::get('/admin','AuthController@addAdmin');


Route::get('/search/{string}','MapController@search');

Route::get('/users/search/{string}','AuthController@searchUsers');


Route::get('/show/users','AuthController@showUsers');


Route::get('/profile', function(){
	return view('profile');
});

Route::post('/map/delete/{id}','MapController@deleteMap');
Route::post('/users/delete/{id}','AuthController@deleteUser');

Route::get('/get','AuthController@get');

Route::get('/Departement/show','MapController@showSubProjects');

Route::post('/profile/edit/{id}','AuthController@editeProfile');
Route::get('/profile/edit/{id}','AuthController@getProfile');
Route::get('/map/show/{id}','MapController@getMap');


