<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Mailtrap\Transport\MailtrapTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class MailTrapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //        // Register custom mailer transport: mailtrap

        $this->app->make('mail.manager')->extend('mailtrap', function ($config) {
            $factory = new MailtrapTransportFactory();

            return $factory->create(Dsn::fromString(env('MAILER_DSN')));
        });
    }
}
