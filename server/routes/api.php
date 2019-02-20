<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: content-type');
use Illuminate\Http\Request;

Route::post('/login','cookieController@setCookie');
Route::post('/create','cookieController@create');
Route::get('/profile','cookieController@verLogin');
Route::get('/posts/get','postController@get');
Route::post('/posts/make','postController@make');
Route::post('/ver','cookieController@ver');
