<?php

namespace App\Providers;

use App\Events\CreateProviderProcessed;
use App\Events\DeletedProviderProcessed;
use App\Events\UserRegisteredEvent;
use App\Listeners\AssignEmployeesRole;
use App\Listeners\SendEmailNotification;
use App\Listeners\SetDefaultRoleForEmployees;
use App\Listeners\SetEmployerRole;
use App\Models\User;
use App\Observers\UserObserver;
use Google\Service\DisplayVideo\AssignedUserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // ... other providers
            \SocialiteProviders\Discord\DiscordExtendSocialite::class.'@handle',
            \SocialiteProviders\Twitter\TwitterExtendSocialite::class.'@handle',
        ],
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            DeletedProviderProcessed::class,
            [SetDefaultRoleForEmployees::class, 'handle']
        );
        Event::listen(
            CreateProviderProcessed::class,
            [SetEmployerRole::class, 'handle']
        );
    }
}
