<?php

//Public pages
Route::middleware("throttle:200,1")->namespace("General")->group(function (){
    Route::get("/home", "FrontController@home");

    Route::get("/campaign-categories", "CampaignController@getCategories");

    Route::prefix("/campaigns")->group(function () {
        Route::get("", "CampaignController@index");
        Route::get("/{id}", "CampaignController@show");
        Route::get("/{campaign_id}/gallery", "GalleryController@index");
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
Route::middleware("throttle:40,1")->namespace("Auth")->group(function (){
	Route::post("/login", "AuthController@login");
	Route::post("/register", "AuthController@register");
    Route::post("/send-password-reset", "ForgotPasswordController@sendResetEmail");
    Route::post("/reset-password", "ResetPasswordController@callReset");

    //TODO give prefix to this group "/user" and correct those in vue store
	Route::middleware("auth:api")->group(function (){
	    Route::post("/user/is_admin", "AuthController@checkAdmin")->middleware("admin");
        Route::post("/email/verify/{id}", "VerificationController@verify")->name("verification.verify");
        Route::post("/email/resend", "VerificationController@resend")->name("verification.resend");
        Route::post("/logout", "AuthController@logout");
        Route::get("/user", "AuthController@details");
    });
});

//User features
Route::middleware("throttle:120,1")->middleware("auth:api")->namespace("User")->group(function (){
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

        //Gallery CRUD
        Route::prefix("/campaigns/{campaign_id}/gallery")->group(function(){
            Route::get("", "GalleryController@index");
            Route::post("", "GalleryController@store");
            Route::delete("/{image_id}", "GalleryController@destroy");
        });

        //Favorite campaigns crud
        Route::prefix("/favourite-campaigns")->group(function(){
           Route::get("", "SavedCampaignController@index");
           Route::post("", "SavedCampaignController@store");
           Route::get("/{campaign_id}", "SavedCampaignController@show");
           Route::delete("/{campaign_id}", "SavedCampaignController@destroy");
        });
    });

    Route::get("/user/survey", "SurveyController@survey");
    Route::post("/campaigns/{campaign_id}/survey", "SurveyController@store");

});

//Admin routes
Route::middleware(["auth:api", "admin"])->prefix("/admin")->namespace("Admin")->group(function () {
    Route::apiResource("/faq", "FAQController");
    Route::apiResource("/campaigns", "CampaignController");
    Route::apiResource("/campaign-categories", "CampaignCategoryController");
    Route::apiResource("/surveys", "SurveyController");
    Route::apiResource("/advertisers", "AdvertiserController");
    Route::get("/advertisers/{id}/get-filled-surveys", "AdvertiserController@filledSurveys");
    Route::prefix("/campaigns/{campaign_id}/gallery")->group(function(){
        Route::get("", "GalleryController@index");
        Route::post("", "GalleryController@store");
        Route::delete("/{image_id}", "GalleryController@destroy");
    });
    Route::prefix("/users")->group(function (){
       Route::get("", "UserController@index");
       Route::delete("/{user_id}", "UserController@destroy");
    });
});