<?php

namespace Imrancse94\Grocery;

use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Imrancse94\Grocery\app\Exceptions\Handler;
use Imrancse94\Grocery\app\Http\Middleware\GroceryAuth;
use Imrancse94\Grocery\app\Http\Middleware\Permission;
use Imrancse94\Grocery\app\Models\GroceryUser;
use Imrancse94\Grocery\libs\JwtGuard;

class GroceryServiceProvider extends ServiceProvider
{

    private function interpolateQuery($query, $bindings)
    {
        $pdo = DB::getPdo();
        foreach ($bindings as $binding) {
            // $pdo->quote() escapes the value and wraps it in single quotes
            $query = preg_replace('/\?/', $pdo->quote($binding), $query, 1);
        }
        return $query;
    }

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/grocery.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');


        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'grocery');


        // Publish config
        $this->publishes([
            __DIR__ . '/config/grocery.php' => config_path('grocery.php'),
        ],'grocery');

        // Publish assets
        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'grocery');


         DB::listen(function ($query) {
             $rawSql = $this->interpolateQuery($query->sql, $query->bindings);
             info($rawSql);
         });

        Config::set('auth.guards.grocery', [
            'driver' => 'grocery',
            'provider' => 'grocery_users',
        ]);

        // Will use the EloquentUserProvider driver with the Admin model
        Config::set('auth.providers.grocery_users', [
            'driver' => 'eloquent',
            'model' => GroceryUser::class,
        ]);

        $this->app['router']->aliasMiddleware('groceryAuth', GroceryAuth::class);
        $this->app['router']->aliasMiddleware('permission', Permission::class);


    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom( __DIR__ . '/config/grocery.php',config_path('grocery.php'));

        $this->app->singleton(ExceptionHandlerContract::class, Handler::class);

        $this->app['auth']->extend('grocery', function ($app, $name, array $config) {
            return new JwtGuard($app['request']);
        });
    }

}
