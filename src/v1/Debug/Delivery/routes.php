<?php

// Route::group(['middleware'=>['TokenV1Middleware', 'LoginV1Middleware']], function() {

// 	Route::post('/halo', 'Debug@index');

// 	Route::get('/halo', 'Debug@index');
	
// });

Route::post('/halo', 'Debug@index');

Route::get('/halo', 'Debug@index');