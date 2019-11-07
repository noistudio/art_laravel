<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use adminmenu\events\EventAdminLink;
use admins\events\EventAdminRule;
use adminmenu\events\ListenerAdminLink;
use blocks\events\BlockType;
use menu\events\MenuLink;
use forms\events\FormAfterSend;
use forms\events\FormBeforeSend;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventAdminLink::class => [
            \admins\events\ListenerAdminLink::class,
            \logs\events\ListenerAdminLink::class,
            \blocks\events\ListenerAdminLink::class,
            \content\events\ListenerAdminLink::class,
            \mg\events\ListenerAdminLink::class,
            \menu\events\ListenerAdminLink::class,
            \forms\events\ListenerAdminLink::class,
            \files\events\ListenerAdminLink::class,
            \mailer\events\ListenerAdminLink::class,
            \cache\events\ListenerAdminLink::class,
            \builder\events\ListenerAdminLink::class,
            \languages\events\ListenerAdminLink::class,
            \routes\events\ListenerAdminLink::class,
        ],
        EventAdminRule::class => [
            \logs\events\AdminRule::class,
            \adminmenu\events\AdminRule::class,
            \blocks\events\AdminRule::class,
            \content\events\AdminRule::class,
            \mg\events\AdminRule::class,
            \menu\events\AdminRule::class,
            \forms\events\AdminRule::class,
            \files\events\AdminRule::class,
            \mailer\events\AdminRule::class,
            \builder\events\AdminRule::class,
        ],
        BlockType::class => [
            \content\events\ContentBlockType::class,
            \mg\events\MgBlockType::class,
            \menu\events\MenuBlockType::class,
            \forms\events\FormBlockType::class,
            \builder\events\BuilderBlockType::class,
        ],
        MenuLink::class => [
            \content\events\ContentMenuLink::class,
            \mg\events\MgMenuLink::class,
            \builder\events\BuilderMenuLink::class,
        ],
        FormAfterSend::class => [],
        FormBeforeSend::class => [],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {
        parent::boot();

        //
    }

}
