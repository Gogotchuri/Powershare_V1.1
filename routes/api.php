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
        Route::get("", "ArticleController@index");
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

//User features
Route::get("/user", "AuthController@details")->middleware("auth:api");
Route::middleware("throttle:60,1")->namespace("User")->group(function (){
    //Comment Crud group
    Route::prefix("campaigns/{campaign_id}/comments")->group(function () {
        Route::get("", "CommentController@index");
        Route::get("/{comment_id}", "CommentController@show");
        //Authorized comment routes
        Route::middleware("auth:api")->group(function (){
            Route::post("", "CommentController@store");
            Route::put("/{comment_id}", "CommentController@update");
            Route::delete("/{comment_id}", "CommentController@destroy");
        });
    });

    // /user routes where authentication is required
    Route::middleware("auth:api")->prefix("/user")->group(function (){
        //Campaign Crud
        Route::apiResource("/campaigns", "CampaignController");
    });

});