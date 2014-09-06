Sentry Manager
==============

A Laravel Package designed to provide User Management out of the box. Uses Cartalyst's Sentry.

Installation
------------

Add `"kkeiper1103/sentry-manager": "dev-master"` to composer.json.

Add `'Kkeiper1103\SentryManager\SentryManagerServiceProvider'` to config/app.php.

Modify the Sentry config to "users.model" => "User" (Or your Model for logging in)

Have your application's User model extend Cartalyst's Eloquent model.

    use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

    class User extends SentryUser implements UserInterface, RemindableInterface {