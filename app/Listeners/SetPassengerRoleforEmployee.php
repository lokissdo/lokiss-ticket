<?php

namespace App\Listeners;

use App\Events\DeleteEmployee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Enums\UserRoleEnum;
class SetPassengerRoleforEmployee implements ShouldQueue
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
     * @param  \App\Events\DeleteEmployee  $event
     * @return void
     */
    public function handle(DeleteEmployee $event)
    {
        User::where("id", $event->user_id)->update(["role" => UserRoleEnum::PASSENGER]);
    }
}
