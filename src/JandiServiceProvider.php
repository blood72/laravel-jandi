<?php

namespace Blood72\Jandi;

use Blood72\Jandi\Notifications\Channels\JandiWebhookChannel;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class JandiServiceProvider extends ServiceProvider
{
    public const VENDOR_CONFIG_PATH = __DIR__ . '/../config/laravel-jandi.php';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([self::VENDOR_CONFIG_PATH => $this->getConfigPath()], 'config');
    }

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::VENDOR_CONFIG_PATH, 'laravel-jandi');

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('jandi', function ($app) {
                return new JandiWebhookChannel(new HttpClient);
            });
        });

        $this->app->singleton(JandiNotifier::class, function ($app) {
            return new JandiNotifier($app['config']->get('laravel-jandi'));
        });

        $this->app->alias(JandiNotifier::class, 'jandi');
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [JandiNotifier::class];
    }

    /**
     * Get the configuration path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('laravel-jandi.php');
    }
}
