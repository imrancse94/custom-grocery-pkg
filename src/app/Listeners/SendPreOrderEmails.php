<?php

namespace Imrancse94\Grocery\app\Listeners;

use Imrancse94\Grocery\app\Events\PreOrderCreated;
use Imrancse94\Grocery\app\Jobs\SendEmailJob;
use Imrancse94\Grocery\app\Mail\PreOrderAdminNotification;
use Imrancse94\Grocery\app\Mail\PreOrderUserConfirmation;

class SendPreOrderEmails
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        info('Lis called c');
    }

    /**
     * Handle the event.
     */
    public function handle(PreOrderCreated $event)
    {
        info('Event Details');

        $preOrder = $event->preOrder;
        // Email to Admin
        dispatch(new SendEmailJob(config('grocery.ADMIN_EMAIL'),new PreOrderAdminNotification($preOrder)));

        // Email to user
        dispatch(new SendEmailJob($preOrder->email,new PreOrderUserConfirmation($preOrder)));

    }
}
