<?php

use Illuminate\Http\Request;

//Public pages
Route::namespace("General")->middleware("throttle:60,1")->group(function (){
    Route::get("/home", "FrontController@home");
    Route::prefix("/campaigns")->group(function () {
        Route::get("", "CampaignController@index");
        Route::get("/{id}", "CampaignController@show");
    });

    Route::prefix("/articles")->group(function () {
        Route::get("", "ArtileController@index");
        Route::get("/{id}", "ArticleController@show");
    });

    Route::get("/faq", "FrontController@FAQ");
    //need to create controller methods for them
    Route::get("/about", "FrontController@about");
    Route::get("/terms", "FrontController@terms");
    Route::get("/privacy-policy", "FrontController@privacyPolicy");

    //Posts contact message to the server
    Route::post('/contact', 'ContactController@store');

});
//Authentication Routes
Route::middleware("throttle:10,1")->group(function (){
	Route::post("/login", "AuthController@login");
	Route::post("/register", "AuthController@register");
    Route::post("/logout", "AuthController@logout")->middleware("auth:api");
});

//User feature paths
Route::middleware("auth:api")->namespace("User")->prefix("/user")->group(function (){
    Route::get("", "AuthController@details");

    Route::resource("/campaigns", "CampaignController");

});