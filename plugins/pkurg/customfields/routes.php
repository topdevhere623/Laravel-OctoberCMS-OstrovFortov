<?php 

//use Illuminate\Contracts\Auth\Factory;
// Route::group(['as' => 'registered1'], function () {

// Route::resource('api/v1/fields', 'Pkurg\Customfields\Controllers\CustomFields');


// });


// Route::get('profile', function () {
//     // Only authenticated users may enter...
// })->middleware('auth');



// Route::get('api/user', ['middleware' => 'web', function () {
//     echo Auth::getUser()->name;
// }]);

// Route::resource('api/v1/fields', 'Pkurg\Customfields\Controllers\CustomFields')
// ->middleware('web');

 

Route::middleware(['Pkurg\Customfields\Middleware\AuthMiddleware'])->group(function() {

// Route::get('api/v1/fields/list', function () {
//         return 'd';
//     });

Route::get('api/v1/fields/list', 'Pkurg\Customfields\Controllers\CustomFields@list');
Route::resource('api/v1/fields', 'Pkurg\Customfields\Controllers\CustomFields');

//

});



//  Route::group(['middleware' => 'auth'], function() {

//     Route::resource('api/v1/fields', 'Pkurg\Customfields\Controllers\CustomFields');
// });


//if (Auth::check()) {

	//Route::resource('api/v1/fields', 'Pkurg\Customfields\Controllers\CustomFields');

//}






?>