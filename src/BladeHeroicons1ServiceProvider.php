<?php

declare(strict_types=1);

namespace BladeUI\Heroicons1;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeHeroicons1ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-heroicons1', []);

            $factory->add('heroicons1', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-heroicons.php', 'blade-heroicons1');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-heroicons1'),
            ], 'blade-heroicons1');

            $this->publishes([
                __DIR__.'/../config/blade-heroicons.php' => $this->app->configPath('blade-heroicons1.php'),
            ], 'blade-heroicons1-config');
        }
    }
}
