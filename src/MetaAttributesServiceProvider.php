<?php

namespace Nncodes\MetaAttributes;

use Illuminate\Support\ServiceProvider;
use Nncodes\MetaAttributes\Commands\MetaAttributesCommand;

class MetaAttributesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-meta-attributes.php' => config_path('laravel-meta-attributes.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-meta-attributes'),
            ], 'views');

            $migrationFileName = 'create_laravel_meta_attributes_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                MetaAttributesCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-meta-attributes');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-meta-attributes.php', 'laravel-meta-attributes');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
