<?php
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

Route::get('/tools/server', function (){
    return view('tools.apiIndex');
});

Route::get('/tools/test','ToolsController@test');

Route::get('/tools/java', function (){
    return view('tools.dto');
});

Route::post('/tools/createDTO', function (Request $request){
    $code = $request->get("code");
    $path = $request->get("path");
    echo file_put_contents($path,$code);
});

Route::post('/tools/parseSql','ToolsController@parseSql');

Route::get('/tools/post', function (){

//    echo preg_replace("/{(\w+)}/","","/pay-service/vip/cancel/status/{userId}");
//    echo "<br>";
//    echo preg_replace("/(\d+)/","","/pay-service/vip/cancel/status/34");
    //echo urldecode("accessToken=id%3D55022013%26nickname%3D%25E6%25B5%258B5171%26avatarUrl%3Dhttp%253A%252F%252Fcdn.static.17k.com%252Ftest%252Fuser%252Favatar%252F13%252F13%252F20%252F55022013.jpg-88x88%253Fv%253D1560424883000%26e%3D1587621487%26s%3D03e08cf35a602f95");
    return view('tools.post');
});

Route::post('/tools/postParse','ToolsController@postParse');

Route::post('/tools/insterCode', 'ToolsController@insterCode');
Route::post('/tools/downDto', 'ToolsController@downDto');
Route::post('/tools/apiresult', 'ToolsController@apiresult');
Route::post('/tools/fetchApi', 'ToolsController@fetchApi');
Route::get('/tools/fetchApi', 'ToolsController@fetchApi');
Route::get('//tools/doServer', 'ToolsController@doServer');
