<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 9/4/14
 * Time: 9:21 AM
 */

return array(

    // the layouts that sentry-manager should use
    "layouts" => array(
        "admin" => "sentry-manager::layouts.admin",
        "auth" => "sentry-manager::layouts.auth"
    ),

    // define the application's user groups here,
    // then run the artisan task for installing them
    "groups" => array(

        "admin" => array(
            'name' => "Admin",
            "permissions" => array(
                "admin.users" => 1,
                "admin.posts" => 1,
                "admin.roles" => 1
            )
        ),

        "moderator" => array(
            "name" => "Moderator",
            "permissions" => array(
                "admin.users" => 1,
                "admin.posts" => 1,
                "admin.roles" => 0
            )
        ),

        "editor" => array(
            "name" => "Editor",
            "permissions" => array(
                "admin.users" => 0,
                "admin.posts" => 1,
                "admin.roles" => 0
            )
        ),

        "user" => array(
            "name" => "User",
            "permissions" => array(
                "admin.users" => 0,
                "admin.posts" => 0,
                "admin.roles" => 0
            )
        )

    ),

    'group-settings' => [
        // admin user group's NAME
        "administrator" => "Admin",

        // default user group's NAME
        "default" => "User"
    ],

    // rules for how the password should be validated on new user creation
    "password_rules" => "required|min:8|confirmed",

    // rules for password validator on user update
    "password_rules_update" => "required_with:password_confirmation|min:8|confirmed",

    // URL base for the users section
    "url_base" => "cp"

);