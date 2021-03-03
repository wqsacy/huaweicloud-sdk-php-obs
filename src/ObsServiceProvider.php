<?php

namespace Wangqs\Obs;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

/**
 * Class ObsServiceProvider
 * @package Obs
 */
class ObsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('obs', function ($app, $config) {
            $debug = $config['debug'] ?? false;
            $endpoint = $config['endpoint'] ?? '';
            $cdn_domain = $config['cdn_domain'] ?? '';
            $ssl_verify = $config['ssl_verify'] ?? false;

            if ($debug) {
                Log::debug('OBS config:', $config);
            }

            $client = new ObsClient($config);

            $bucket = $config['bucket'] ?? '';

            return new Filesystem(new ObsAdapter($client, $bucket, $endpoint, $cdn_domain, $ssl_verify));
        });
    }
}
