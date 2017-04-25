<?php

namespace App\Listeners;

use App\Events\AgentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUser
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
     * @param  AgentCreated  $event
     * @return void
     */
    public function handle(AgentCreated $event)
    {
        //
    }
}
