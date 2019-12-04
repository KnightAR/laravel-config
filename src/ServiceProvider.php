<?php

namespace KnightAR\Laravel\Config;

use KnightAR\Laravel\Config\Storage\Eloquent;
use KnightAR\Laravel\Config\Storage\File;
use KnightAR\Laravel\Config\Storage\Pdo;
use KnightAR\Laravel\Config\Storage\Redis;
use KnightAR\Laravel\Config\Storage\StorageInterface;
use Illuminate\Contracts\Config\Repository as LaravelConfig;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Service Provider for Config
 *
 * @package KnightAR\Laravel\Config;
 */
class ServiceProvider extends BaseServiceProvider
{
    protected $defer = false;
    protected $config;

    /**
     * @inheritdoc
     */
    public function boot()
    {
        # publish necessary files
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('runtimeconfig.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/migrations/' => database_path('migrations'),
        ], 'migrations');

        foreach(app()->make('config-runtime')->all() as $parent => $values) {
            $this->mergeAndOverwriteConfigFromArray($parent, $values);
        }
    }

    public function mergeAndOverwriteConfigFromArray($key, $values) {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, array_replace_recursive($config, $values));
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $configPath = __DIR__ . '/config/config.php';
        $this->mergeConfigFrom($configPath, 'runtimeconfig');
        $this->app->singleton('config-runtime', function () {
            $storage = $this->selectStorage($this->app['config']);
            if ($storage === null) {
                $storage = [];
            }
            $cfg = new Config($storage);
            $modifiers = $this->app['config']->get('runtimeconfig.modifiers', []);
            foreach ($modifiers as $className) {
                $cfg->modifiers->push(new $className);
            }

            return $cfg;
        });
    }

    /**
     * Define the services this provider will build & provide
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'KnightAR\Laravel\Config\Config',
            'config-runtime'
        ];
    }

    /**
     * Retrieve the storage engine, based on the current configuration
     *
     * @param  LaravelConfig $config
     * @return StorageInterface
     */
    protected function selectStorage($config)
    {
        if (!$config->get('runtimeconfig.storage.enabled')) {
            return null;
        }
        $driver = $config->get('runtimeconfig.storage.driver', 'file');
        $method = 'selectStorage'.ucfirst($driver);
        return $this->$method($config);
    }

    /**
     * Get an instance of the PDO storage engine
     *
     * @param  LaravelConfig $config
     * @return Pdo
     */
    protected function selectStoragePdo($config)
    {
        $table = $config->get('runtimeconfig.storage.table');
        $connection = $config->get('runtimeconfig.storage.connection');
        $table = $this->app['db']->getTablePrefix() . $table;
        $pdo = $this->app['db']->connection($connection)->getPdo();
        return new Pdo($pdo, $table);
    }

    /**
     * Get an instance of the Redis storage engine
     *
     * @param  LaravelConfig  $config
     * @return Redis
     */
    protected function selectStorageRedis($config)
    {
        $connection = $config->get('runtimeconfig.storage.connection');
        return new Redis($this->app['redis']->connection($connection));
    }

    /**
     * Get an instance of a custom defined storage engine
     *
     * @param  LaravelConfig $config [description]
     * @return StorageInterface
     */
    protected function selectStorageCustom($config)
    {
        $class = $config->get('runtimeconfig.storage.provider');
        return $this->app->make($class);
    }

    /**
     * Get an instance of the File storage engine
     *
     * @param  LaravelConfig $config
     * @return File
     */
    protected function selectStorageFile($config)
    {
        $path = $config->get('runtimeconfig.storage.path');
        return new File($path);
    }

    /**
     * Get an instance of the File storage engine
     *
     * @param  LaravelConfig $config
     * @return File
     */
    protected function selectStorageEloquent($config)
    {
        return new Eloquent();
    }
}
