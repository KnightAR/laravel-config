<?php

namespace KnightAR\Laravel\Config\Traits;

use Illuminate\Support\Str;

trait BindsDynamically
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (!function_exists('app')) {
            return 'runtime_config';
        }
        return app('config')->get('runtimeconfig.storage.table') ?? 'runtime_config';
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        if (!function_exists('app')) {
            return null;
        }
        return app('config')->get('runtimeconfig.storage.connection');
    }
}