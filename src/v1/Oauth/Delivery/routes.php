<?php

Route::post('/token', 'Token@GenerateToken');

Route::group(['middleware'=>['BasicAuthMiddleware']], function() {
	Route::post('/register', 'Token@RegisterClient');
});