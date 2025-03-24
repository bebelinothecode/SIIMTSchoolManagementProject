<?php

namespace App\Listeners;

use App\User;
use App\Events\DocumentRequestSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAdminOfNewRequest
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
     * @param  \App\Events\DocumentRequestSubmitted  $event
     * @return void
     */
    public function handle(DocumentRequestSubmitted $event)
    {
        $admins = User::role('Admin')->get();
        Notification::send($admins, new DocumentRequestSubmitted($event->documentRequest));
    }
}
