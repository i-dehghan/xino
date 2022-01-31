<?php

namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
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
        $configs = Config::all();
        foreach ($configs as $config) {
            \Illuminate\Support\Facades\Config::set('configs.' . $config->key, $config->value);
        }
    }
}
