<?php

namespace JfelixStudio\MysqlEncrypt\Providers;

use Illuminate\Support\ServiceProvider;
use JfelixStudio\MysqlEncrypt\Traits\ValidatesEncrypted;

class LaravelServiceProvider extends ServiceProvider
{
    use ValidatesEncrypted;

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('mysql-encrypt.php'),
        ], 'config');

        $this->addValidators();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'mysql-encrypt');
    }
}
