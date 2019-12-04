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
        return app('config')->get('runtimeconfig.storage.table') ?? 'runtime_config';
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return app('config')->get('runtimeconfig.storage.connection');
    }
}