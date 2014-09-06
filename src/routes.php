<?php

// all controllers are found in the given namespace
Route::group(['namespace' => '\Kkeiper1103\SentryManager\controllers'], function()
{

    // force these to have authentication before access
    Route::group(["before" => "sentry.auth|sentry.is:admin.users"], function(){
        Route::resource( \Config::get("sentry-manager::url_base") . "/users", "UserController");
    });

    // lastly, have sentry/* be handled by the SentryManager controller
    Route::controller( \Config::get("sentry-manager::url_base") , "SentryManager");

});