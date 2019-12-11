<?php

Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@authenticate');


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('products', 'Api\ProductController');
});