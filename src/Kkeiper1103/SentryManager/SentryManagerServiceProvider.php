<?php namespace Kkeiper1103\SentryManager;

use Illuminate\Support\ServiceProvider;

class SentryManagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->package('kkeiper1103/sentry-manager');

        $this->commands("commands.installGroupCommand");
        $this->commands("commands.installSuperuserCommand");

        require __DIR__.'/../../routes.php';
        require __DIR__.'/../../filters.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        //
        $this->app['SentryManager'] = $this->app->share(function ($app)
        {
            return new SentryManager();
        });

        // register dependent service providers
        $this->app->register('Andheiberg\Notify\NotifyServiceProvider');
        $this->app->register('Cartalyst\Sentry\SentryServiceProvider');

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Notify', '\Andheiberg\Notify\Facades\Notify');
            $loader->alias("Sentry", 'Cartalyst\Sentry\Facades\Laravel\Sentry');
        });

        // register artisan commands
        $this->app->bind("commands.installGroupCommand", function($app){
            return new \Kkeiper1103\SentryManager\commands\InstallGroupsCommand;
        });

        $this->app->bind("commands.installSuperuserCommand", function($app){
            return new \Kkeiper1103\SentryManager\commands\InstallSuperuserCommand;
        });

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array("SentryManager");
	}

}
