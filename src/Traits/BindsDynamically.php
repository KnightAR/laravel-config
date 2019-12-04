<?php

namespace KnightAR\Laravel\Config\Traits;

trait BindsDynamically
{
    protected $connection = null;
    protected $table = null;

    public function bind(string $connection, string $table)
    {
        $this->setConnection(app('config')->get('runtimeconfig.storage.connection'));
        $this->setTable(app('config')->get('runtimeconfig.storage.table') ?? 'runetime_config');
    }

    public function newInstance($attributes = [], $exists = false)
    {
        // Overridden in order to allow for late table binding.

        $model = parent::newInstance($attributes, $exists);
        $model->setConnection(app('config')->get('runtimeconfig.storage.connection'));
        $model->setTable(app('config')->get('runtimeconfig.storage.table') ?? 'runetime_config');

        return $model;
    }
}