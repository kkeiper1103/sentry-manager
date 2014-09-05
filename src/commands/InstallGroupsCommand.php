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

use Cartalyst\Sentry\Groups\GroupNotFoundException;

class InstallGroupsCommand extends Command {

    protected $name = "sm:install.groups";

    protected $description = "Install The Groups In SentryManager's Configuration File.";

    public function fire()
    {
        $groups = Config::get("sentry-manager::groups");

        // install the groups
        foreach( $groups as $key => $value )
        {
            try
            {
                $g = Sentry::findGroupByName( $value['name'] );

                $g->permissions = $value['permissions'];

                $g->save();
            }
            // if the group isn't found, simply create it and move on.
            catch( GroupNotFoundException $e )
            {
                $g = Sentry::createGroup($value);
            }

            $this->line("Updated Group {$key}.");
        }
    }

} 