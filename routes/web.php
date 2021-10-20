<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

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

// Route::view('/pier', 'pier');

Route::get('/', function () {
    return view('home');
});

Route::post('test/staging', function (Request $request) {
    return response()->json([
        "msg" => "webhook live",
        "data" => $request->all()
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/cms', 'CMSController@index')->name('cms');
Route::post('/upload_file', 'CMSController@upload_file')->name('upload_file');
Route::get('/link_preview', 'CMSController@link_preview');

Route::prefix('model')->group(function () {
    Route::post('/', 'EditorController@create');
    Route::get('/', 'EditorController@list');
    // Route::get('/migrateFresh', function(){
    //     return Artisan::call('migrate:fresh');
    // });
    Route::get('{model_name}/truncate', 'EditorController@truncate');
    Route::get('{model_name}/drop', 'EditorController@drop');
    Route::post('{model_name}/populate', 'EditorController@populate');
    Route::get('{model_name}/describe', 'EditorController@describe');
    Route::get('{model_name}/settings', 'EditorController@settings');
    Route::patch('{model_name}', 'EditorController@update');
    Route::patch('{model_name}/addField', 'EditorController@add_field');
    Route::patch('{model_name}/settings', 'EditorController@update_settings');
    Route::get('{model_name}/browse', 'EditorController@browse');
});

Route::prefix('api')->group(function () {
    // Route::post('{model_name}/populate', 'EditorController@populate');
    Route::get('{model_name}/search', 'APIController@searchResource');
    Route::get('{model_name}/{row_id?}', 'APIController@resource');
    Route::post('{model_name}', 'APIController@createResource');
    Route::post('{model_name}/upload_file', 'APIController@upload_file');
    Route::patch('{model_name}/{row_id}', 'APIController@updateResource');
    Route::delete('{model_name}/{row_id}', 'APIController@deleteResource');
});