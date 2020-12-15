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
                __DIR__ . '/../config/meta-attributes.php' => config_path('meta-attributes.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/meta-attributes'),
            ], 'views');

            $migrationFileName = 'create_meta_attributes_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                MetaAttributesCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'meta-attributes');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/meta-attributes.php', 'meta-attributes');
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
