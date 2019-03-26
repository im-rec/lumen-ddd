<?php

Route::group(['middleware'=>['TokenV1Middleware']], function() {
	Route::post('/login', 'Login@Login');
});

