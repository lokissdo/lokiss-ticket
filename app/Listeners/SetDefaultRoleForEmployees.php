<?php

namespace App\Listeners;

use App\Events\DeletedProviderProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Enums\UserRoleEnum;
use App\Models\EmployeesList;

class SetDefaultRoleForEmployees implements ShouldQueue
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
     * @param  \App\Events\DeletedProviderProcessed  $event
     * @return void
     */
    public function handle(DeletedProviderProcessed $event)
    {
        $employer = User::find($event->employer_id);
        $employer->role = UserRoleEnum::PASSENGER;
        $employer->save();
        $ids = DB::table('employees_list')
            ->select('id')
            ->where('employees_list.service_provider_id', $event->provider_id);
        User::joinSub($ids, 'employee_ids', function ($join) {
            $join->on('users.id', '=', 'employee_ids.id');
        })
            ->update(['role' => UserRoleEnum::PASSENGER]);

        EmployeesList::where('service_provider_id', $event->provider_id)->delete();

    }
}
