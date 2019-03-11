<?php

use Illuminate\Http\Request;

//Authentication Routes
Route::middleware("throttle:10,1")->group(function (){
	Route::post("/login", "AuthController@login");
	Route::post("/register", "AuthController@register");
});

//User managment paths
Route::middleware("auth:api")->group(function (){
    Route::get("/user", "AuthController@details");
    Route::post("/logout", "AuthController@logout");
});

//Public pages
Route::namespace("General")->middleware("throttle:60,1")->group(function (){
    Route::get("/campaigns", "CampaignController@index");
    Route::get("/campaigns/{id}", "CampaignController@show");
    Route::get("/FAQ", "FrontController@FAQ");
});