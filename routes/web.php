<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//group Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('group','\App\Http\Controllers\GroupController');
  Route::post('group/{id}/update','\App\Http\Controllers\GroupController@update');
  Route::get('group/{id}/delete','\App\Http\Controllers\GroupController@destroy');
});


Route::get('', 'VueContactController@manageVue');
Route::get('vuecontact/search','\App\Http\Controllers\VueContactController@search');
Route::resource('vuecontact','VueContactController');
