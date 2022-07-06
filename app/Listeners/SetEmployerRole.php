<?php

namespace App\Listeners;

use App\Enums\UserRoleEnum;
use App\Events\CreateProviderProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class SetEmployerRole
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
     * @param  \App\Events\CreateProviderProcessed  $event
     * @return void
     */
    public function handle(CreateProviderProcessed $event)
    {
        $employer=User::find($event->user_id);
        $employer->role=UserRoleEnum::EMPLOYER;
        $employer->save();
    }
}
