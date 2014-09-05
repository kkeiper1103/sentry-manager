<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 9/4/14
 * Time: 9:14 AM
 */

Route::filter("sentry.auth", function(){

    if ( ! Sentry::check())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::guest('sentry/login');
        }
    }

});

Route::filter('sentry.guest', function()
{
    if (Sentry::check()) return Redirect::to('/');
});

Route::filter("sentry.is", function($route, $request){

    $filterArgs = array_slice(func_get_args(), 2 );

    if( ! Sentry::getUser()->hasAccess($filterArgs) )
    {
        Notify::error("You Do Not Have Permission To Access This Area.");
        return Redirect::to("/");
    }
});