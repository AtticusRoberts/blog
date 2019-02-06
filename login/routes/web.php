<?php
Route::get('/',function() {
  return view('home');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/create', function() {
    return view('createAccount');
});
Route::get('/blog','cookieController@authCookie');
Route::post('/login','cookieController@setCookie');
Route::post('/create','cookieController@create');
Route::get('/profile','cookieController@verLogin');
Route::get('/posts/get','postController@get');
Route::post('/blog/make','postController@make');
