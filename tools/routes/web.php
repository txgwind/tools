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

Route::get('/', function () {
    return view('tools.address');
});


Route::get('/tools', function () {
    return view('tools.index');
});

Route::get('/tools/show', 'ToolsController@show');
Route::post('/tools/parse','ToolsController@parse');
Route::get('/tools/sql', 'ToolsController@sql');
Route::get('/tools/api', function (){
    return view('tools.api');
});
Route::post('/tools/insterCode', 'ToolsController@insterCode');

Route::post('/tools/apiresult', 'ToolsController@apiresult');