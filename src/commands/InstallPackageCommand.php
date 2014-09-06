<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 9/4/14
 * Time: 11:14 AM
 */

namespace Kkeiper1103\SentryManager\commands;

use Illuminate\Console\Command;
use Config;
use Sentry;

class InstallPackageCommand extends Command {

    protected $name = "sm:install";

    protected $description = "Installs the Sentry Manager Package, calling the sub-commands needed.";

    public function fire()
    {

        // first, we'll need to make sure that cartalyst is installed
        $this->call( "migrate", ["--package" => "cartalyst/sentry"] );

        // now publish the configurations
        $this->call( "config:publish", ["package" => "cartalyst/sentry"] );
        $this->call( "config:publish", ["package" => "kkeiper1103/sentry-manager"] );

        // now install the groups from SentryManager
        $this->call( "sm:install.groups" );
        $this->info("To Change The Groups Installed, Simple Edit The 'groups' Array in Sentry Manager's Config and re-run 'php artisan sm:install.groups'.");

        // now install the superuser for the CMS
        $this->call( "sm:install.superuser" );

    }

} 