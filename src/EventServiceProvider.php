<?php

namespace Imrancse94\Grocery;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Imrancse94\Grocery\app\Events\PreOrderCreated;
use Imrancse94\Grocery\app\Listeners\SendPreOrderEmails;
//use Illuminate\Events\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        PreOrderCreated::class => [
            SendPreOrderEmails::class,
        ],
    ];
    /**
     * Register services.
     */


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
