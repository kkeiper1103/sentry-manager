<?php

namespace Kkeiper1103\SentryManager\controllers;

use Sentry;
use Controller;
use Input;
use Redirect;
use View;
use Config;
use Response;
use Validator;
use Notify;
use Mail;

/**
 * Class SentryManager
 * @package Kkeiper1103\SentryManager\controllers
 */
class SentryManager extends Controller{

    /**
     * @method getLogin
     * GET sentry/login
     * @return mixed
     */
    public function getLogin()
    {
        return View::make("sentry-manager::sentry.login");
    }

    /**
     * @method postLogin
     * POST sentry/login
     * @return mixed
     */
    public function postLogin()
    {
        try
        {
            $user = Sentry::authenticate([

                // instead of hardcoding the login attribute to email or username,
                // this allows the login attribute to be changed simply by
                // changing the field in the sentry configuration file.
                \Config::get("cartalyst/sentry::users.login_attribute") => Input::get(\Config::get("cartalyst/sentry::users.login_attribute")),

                "password" => Input::get("password")

            ], Input::get("remember", false));

            Notify::success( "Successfully Logged In." );

            return Redirect::to("/");
        }
        catch(\Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            $user = Sentry::findUserByLogin( Input::get(\Config::get("cartalyst/sentry::users.login_attribute")) );
            Notify::error( "This User Account is Not Activated. <a href=\"". url("sentry/send-activation-email/{$user->id}") ."\">Resend Activation Email</a>." );
        }
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            Notify::error('User is suspended.');
        }
        catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            Notify::error('User is banned.');
        }
        catch(\Exception $e)
        {
            Notify::error("Invalid Credentials Supplied.");
        }

        return redirect::to( \Config::get("sentry-manager::url_base") . "/login" );

    }

    /**
     * @method getLogout
     * GET sentry/logout
     * @return mixed
     */
    public function getLogout()
    {
        Sentry::logout();

        Notify::success( "Successfully Logged Out." );

        return Redirect::to("/");
    }

    /**
     * @method getRegister
     * GET sentry/register
     * @return mixed
     */
    public function getRegister()
    {
        return View::make("sentry-manager::sentry.register");
    }

    /**
     * @method postRegister
     * POST sentry/register
     * @return mixed
     */
    public function postRegister()
    {

        $v = Validator::make(Input::all(), [
            // see postLogin for explanation of this
            \Config::get("cartalyst/sentry::users.login_attribute") => "required",
            "password" => \Config::get("sentry-manager::password_rules")
        ]);

        // if the new user passes validation
        if($v->passes())
        {
            try
            {
                $userArgs = array(
                    \Config::get("cartalyst/sentry::users.login_attribute") => Input::get( \Config::get("cartalyst/sentry::users.login_attribute") ),
                    "password" => Input::get("password"),
                    "first_name" => Input::get("first_name"),
                    "last_name" => Input::get("last_name")
                );

                $user = Sentry::createUser($userArgs);
            }
            catch(\Cartalyst\Sentry\Users\UserExistsException $e)
            {
                Notify::error("User Already Exists!");
                return Redirect::to("sentry/register")->withInput();
            }
            catch(\Exception $e)
            {
                Notify::error( "There Was An Error Processing Your Registration. Please Try Again." );
                return Redirect::to("sentry/register")->withInput();
            }

            $this->_sendActivationEmail( $user->id );

            Notify::success("User Has Been Created. Please Check The Email Given for Further Instructions.");

            return Redirect::to("/");
        }

        Notify::error("There Were Errors With Your Registration. Please See Below.");

        return Redirect::to( \Config::get("sentry-manager::url_base") . "/register")->withErrors($v);
    }

    /**
     * @method getForgot
     * GET sentry/forgot
     * @return mixed
     */
    public function getForgot()
    {
        return View::make( "sentry-manager::sentry.forgot" );
    }

    /**
     * @method postForgot
     * POST sentry/forgot
     * @return mixed
     */
    public function postForgot()
    {
        try
        {
            $user = Sentry::findUserByLogin( Input::get( \Config::get("cartalyst/sentry::users.login_attribute") ) );

            $resetCode = $user->getResetPasswordCode();

            /**
             * send password reset email
             */
            Mail::send("sentry-manager::emails.forgot", array("token" => $resetCode, "user" => $user), function($msg) use ($user){
                $msg->to($user->getReminderEmail())->subject("Password Reset");
            });
        }
        // catch exception and do nothing so they can't tell if they hit an account or not.
        catch(\Exception $e)
        {}

        Notify::success("Password Reset Email Has Been Sent. Please Check Your Email For More Instructions.");

        return Redirect::to( \Config::get("sentry-manager::url_base") . "/login" );
    }


    /**
     * @method getReset
     * GET sentry/reset/:id/:token
     * @param $id
     * @param $token
     * @return mixed
     */
    public function getReset($id, $token)
    {
        return View::make("sentry-manager::sentry.reset")
            ->with("id", $id)
            ->with("token", $token);
    }

    /**
     * @method postReset
     * POST sentry/reset/:id/:token
     * @param $id
     * @param $token
     * @return mixed
     */
    public function postReset($id, $token)
    {
        try
        {
            $user = Sentry::findUserById( $id );

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode( $token ))
            {
                $v = Validator::make(Input::all(), [
                    "password" => \Config::get("sentry-manager::password_rules")
                ]);

                // if the password is a valid password
                if($v->passes())
                {
                    // Attempt to reset the user password
                    if ($user->attemptResetPassword( $token , Input::get("password")))
                    {
                        Notify::success("Password Successfully Reset. Please Log In.");
                        return Redirect::to( \Config::get("sentry-manager::url_base") . "/login" );
                    }
                    else
                    {
                        Notify::error("Password Could Not Be Reset. Please Try Again.");
                    }
                }
                else
                {
                    return Redirect::to( \Config::get("sentry-manager::url_base") . "/reset/{$id}/{$token}")->withErrors($v);
                }
            }
            else
            {
                Notify::error("Invalid Password Reset Code.");
                return Redirect::to( \Config::get("sentry-manager::url_base") . "/login" );
            }
        }
        catch(\Exception $e)
        {}

        return Redirect::to( \Config::get("sentry-manager::url_base") . "/login" );
    }


    /**
     * @method getActivate
     * GET sentry/activate/:id/:token
     * @param $id
     * @param $token
     * @return mixed
     */
    public function getActivate($id, $token)
    {
        $user = Sentry::findUserById($id);

        try
        {
            $user->attemptActivation($token);

            // notify that user is activated
            Notify::success("User Has Been Activated.");
        }
        catch(\Exception $e)
        {
            // notify that user could not be activated
            Notify::error("User Could Not Be Activated Or Is Already Activated.");
        }

        return Redirect::to( \Config::get("sentry-manager::url_base") . "/login" );
    }

    /**
     * @method _sendActivationEmail
     *
     * @param $userId
     */
    protected function _sendActivationEmail( $userId )
    {
        $user = Sentry::findUserById($userId);

        if( ! $user->isActivated() )
        {
            $token = $user->getActivationCode();

            /**
             * Send activation email since someone has registered
             */
            Mail::send("sentry-manager::emails.registration", array("token" => $token, "user" => $user), function($msg) use ($user){

                $msg->to($user->getReminderEmail())->subject("New Account Created. Please Activate.");

            });
        }
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getSendActivationEmail( $userId )
    {
        $this->_sendActivationEmail($userId);

        Notify::success("Sent Activation Email To User.");

        return Redirect::to( Sentry::check() ? \Config::get("sentry-manager::url_base") . "/users" : \Config::get("sentry-manager::url_base") . "/login" );
    }

    /**
     * @method missingMethod
     * @param $params array
     * GET sentry/{anything-that-doesnt-exist}
     * @return mixed
     */
    public function missingMethod($params = array())
    {
        return Response::make("Not Found", 404);
    }



} 