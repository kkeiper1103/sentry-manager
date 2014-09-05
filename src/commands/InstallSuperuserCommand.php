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

class InstallSuperuserCommand extends Command {

    protected $name = "sm:install.superuser";

    protected $description = "Install The SuperUser";

    public function fire()
    {
        $login_attr = Config::get('cartalyst/sentry::users.login_attribute');

        $username = $this->ask("{$login_attr}: ");

        $password = $this->secret("Password: ");

        $conf = $this->secret("Password, Again: ");

        // if the password match, continue
        if( strcmp($password, $conf) === 0 )
        {
            $superUser = Sentry::createUser([
                $login_attr => $username,
                "password" => $password,
                'activated' => true,
                'permissions' => array(
                    'superuser' => 1
                )
            ]);

            $this->info("New Superuser Has Been Activated. Log In Using the Credentials Supplied.");
        }
        else
        {
            $this->error("Passwords Don't Match. Run Command Again.");
        }
    }

} 