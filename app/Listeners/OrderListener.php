<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class OrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->order) {
            // client instance 
            $customer     = $event->order->customer;
            // admin instance
            $userAdmin  = Admin::first();

            $body = null;

            // send to admin 
            Notification::send($userAdmin, new OrderNotification($event->order, $customer, $body));

            //send to client 
        }
    }
}
