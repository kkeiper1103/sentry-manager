<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 9/4/14
 * Time: 8:59 AM
 */

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

class UserController extends Controller {

    protected $_login_attribute;

    // Used for routing, but NOT view names.
    protected $_url_base;

    public function __construct()
    {
        $this->_login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
        $this->_url_base = \Config::get("sentry-manager::url_base");
    }

    public function index()
    {
        return View::make( "sentry-manager::sentry.users.index" )
            ->with("users", Sentry::findAllUsers())
            ->with("url_base", $this->_url_base);
    }

    public function create()
    {
        $user = new \User();

        return View::make("sentry-manager::sentry.users.create")
            ->with("user", $user)
            ->with("url_base", $this->_url_base);
    }

    public function store()
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

                try
                {
                    // try adding group. don't crash is group isn't found.
                    $user->addGroup(
                        Sentry::findGroupByName(
                            Config::get("sentry-manager::group-settings.default")
                        )
                    );
                }
                catch(\Exception $e)
                {}

            }
            catch(\Cartalyst\Sentry\Users\UserExistsException $e)
            {
                Notify::error("User Already Exists!");
                return Redirect::route("{$this->_url_base}.users.create")->withInput();
            }
            catch(\Exception $e)
            {
                Notify::error( "There Was An Error Processing Your Registration. Please Try Again." );
                return Redirect::route("{$this->_url_base}.users.create")->withInput();
            }

            // by default, when an admin creates a user, don't require activation
            if( Input::get("activated") )
            {
                $user->activated = true;
                $user->save();
            }
            else
            {
                $token = $user->getActivationCode();

                /**
                 * Send activation email since someone has registered
                 */
                Mail::send("sentry-manager::emails.registration", array("token" => $token, "user" => $user), function($msg) use ($user){

                    $msg->to($user->getReminderEmail())->subject("New Account Created. Please Activate.");

                });
            }

            // update user's groups
            foreach( Input::get("groups", array()) as $gId => $shouldBeInGroup )
            {
                if($shouldBeInGroup)
                {
                    $user->addGroup( Sentry::findGroupById($gId) );
                }
                else
                {
                    $user->removeGroup( Sentry::findGroupById($gId) );
                }
            }

            Notify::success("User Has Been Created.");

            return Redirect::route("{$this->_url_base}.users.index");
        }

        Notify::error("There Were Errors With Your Registration. Please See Below.");

        return Redirect::route("{$this->_url_base}.users.create")->withInput()->withErrors($v);
    }

    public function show($id)
    {
        $user = Sentry::findUserById($id);

        return View::make("sentry-manager::sentry.users.show")
            ->with("user", $user)
            ->with("url_base", $this->_url_base);
    }

    public function edit($id)
    {
        $user = Sentry::findUserById($id);

        return View::make("sentry-manager::sentry.users.edit")
            ->with("user", $user)
            ->with("url_base", $this->_url_base);
    }

    public function update($id)
    {
        $v = Validator::make(Input::all(), [
            \Config::get("cartalyst/sentry::users.login_attribute") => "required",
            "password" => \Config::get("sentry-manager::password_rules_update")
        ]);

        // if the new user passes validation
        if($v->passes())
        {
            $user = Sentry::findUserById($id);

            // update fields
            $input = Input::all();

            $user->{$this->_login_attribute} = $input[$this->_login_attribute];
            $user->first_name = $input['first_name'];
            $user->last_name = $input['last_name'];
            $user->activated = $input['activated'];

            if( ! empty($input['password']))
                $user->password = $input['password'];

            $user->save();

            // update user's groups
            foreach( Input::get("groups", array()) as $gId => $shouldBeInGroup )
            {
                if($shouldBeInGroup)
                {
                    $user->addGroup( Sentry::findGroupById($gId) );
                }
                else
                {
                    $user->removeGroup( Sentry::findGroupById($gId) );
                }
            }

            Notify::success( "Successfully Updated User {$user->{$this->_login_attribute}}." );
            return Redirect::route("{$this->_url_base}.users.index");
        }
        else
        {
            Notify::error( "There Were Errors With Your Input." );

            return Redirect::route("{$this->_url_base}.users.edit", $id)
                ->withInput()
                ->withErrors($v);
        }
    }

    public function destroy($id)
    {
        $user = Sentry::findUserById($id);

        $user->delete();

        Notify::success( "User {$user->{$this->_login_attribute}} Has Been Deleted." );

        return Redirect::route("{$this->_url_base}.users.index");
    }

} 