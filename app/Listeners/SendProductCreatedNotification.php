<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProductCreatedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        $users = User::select('id', 'name', 'email')->get();
        foreach ($users as $user) {
            $user->notify(new ProductCreatedNotification($event->product));
        }
    }
}
