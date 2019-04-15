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
    Route::get("/about", "FrontController@about");
    Route::get("/terms", "FrontController@terms");
    Route::get("/privacy-policy", "FrontController@privacyPolicy");

    //Posts contact message to the server
    Route::post("/contact", "ContactController@store");

});

//Authentication Routes
Route::middleware("throttle:20,1")->namespace("Auth")->group(function (){
	Route::post("/login", "AuthController@login");
	Route::post("/register", "AuthController@register");
	Route::middleware("auth:api")->group(function (){
        Route::post("email/verify/{id}", "VerificationController@verify")->name("verification.verify");
        Route::post("email/resend", "VerificationController@resend")->name("verification.resend");
        Route::post("/logout", "AuthController@logout");
        Route::get("/user", "AuthController@details");
    });
});

//User features
Route::middleware("throttle:60,1")->middleware("auth:api")->namespace("User")->group(function (){
    Route::apiResource("/user/campaigns", "CampaignController");
    //Comment Crud group
    Route::prefix("/campaigns/{campaign_id}/comments")->group(function () {
        Route::get("", "CommentController@index");
        Route::post("", "CommentController@store");
    });
    Route::prefix("/user")->group(function (){
        Route::prefix("/comments")->group(function () {
            //might not be necessary
            Route::get("", "CommentController@all");
            Route::get("/{comment_id}", "CommentController@show");
            Route::put("/{comment_id}", "CommentController@update");
            Route::delete("/{comment_id}", "CommentController@destroy");
        });
    });

});

//Admin routes
Route::middleware(["auth:api", "admin"])->prefix("/admin")->namespace("Admin")->group(function () {
    Route::get("/campaigns", "CampaignController@index");
});