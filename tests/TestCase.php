<?php

/*
 * This file is part of HGGAPP.com
 *
 * (c) High Grade Gypsum LLC - 2019
 *     Eric Zhivalyuk (eric@gypsumresources.com)
 *     Brandon Lis (brandon@gypsumresources.com)
 *
 *     DO NOT COPY OR REDISTRIBUTE!
 */

namespace KnightAR\Laravel\Config\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Laravel Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            //\KnightAR\Laravel\Config\Config::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //'config-runtime'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     */
    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        // Laravel App Configs
        $config->set('database.default', 'testing');
        $config->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $config->set('realtimeconfig.storage.enabled', true);
        $config->set('realtimeconfig.storage.driver', 'file');
        $config->set('realtimeconfig.storage.path', __DIR__ . '/assets/invalid.json');
        $config->set('realtimeconfig.storage.table', 'runtime_config');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get table names.
     *
     * @return array
     */
    public function getTablesNames()
    {
        return [
            'runtime_config'
        ];
    }

    // Lifted straight from Illuminate/Support/Str

    public function str_slug($title, $separator = '-')
    {
        // Convert all dashes/underscores into separator
        $flip = $separator === '-' ? '_' : '-';
        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);
        // Replace @ with the word 'at'
        $title = str_replace('@', $separator.'at'.$separator, $title);
        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower($title));
        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);
        return trim($title, $separator);
    }

    /**
     * Get the migrations source path.
     *
     * @return string
     */
    protected function getMigrationsSrcPath()
    {
        return realpath(dirname(__DIR__) . '/src/migrations');
    }

    /**
     * Get the migrations destination path.
     *
     * @return string
     */
    protected function getMigrationsDestPath()
    {
        return realpath(database_path('migrations'));
    }

    /**
     * Migrate the migrations.
     */
    protected function migrate()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom($this->getMigrationsSrcPath());
    }

    /**
     * Reset all migrations.
     */
    protected function resetMigration()
    {
        $this->artisan('migrate:reset')->run();
    }
}