<?php

namespace KnightAR\Laravel\Config\Storage;

use Illuminate\Support\Collection;
use KnightAR\Laravel\Config\Models\RunetimeConfig;

/**
 * Eloquent storage for config
 *
 * @package KnightAR\Laravel\Config\Storage
 */
class Eloquent implements StorageInterface
{
    /**
     * @var string model to use
     */
    protected $model;

    /**
     * constructor
     *
     * @param string $file the file to persist the data two
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function save($key, $value)
    {
        if (is_array($value)) {
            /** @var Collection $existing_keys */
            $existing_keys = $this->model::whereRaw('key LIKE ?[%]', $key)->get();

            foreach ($value as $i => $arrValue) {
                $existing_keys = $existing_keys->where('key', '!=', $key.'['.$i.']');
                $this->saveKey($key.'['.$i.']', $arrValue);
            }
            if ($existing_keys->count() > 0) {
                $existing_keys->map(function($row){ $row->delete(); });
            }
            return;
        }

        $this->saveKey($key, $value);
    }

    /**
     * @inheritdoc
     */
    public function forget($key)
    {
        $this->delKey($key);
    }

    /**
     * Save the specific key into the database
     *
     * @param string $key
     * @param string|int|float $value
     */
    private function saveKey($key, $value)
    {
        return $this->model::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * @inheritdoc
     */
    public function load()
    {
        $results = [];
        foreach ($this->model::where('id', '>', 0)->get() as $row) {
            $results[$row->key] = $row->value;
        }
        return $results;
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->model::truncate();
    }

    /**
     * Delete the requested key from the database storage
     *
     * @param  string $key
     */
    private function delKey($key)
    {
        $this->model::where('key', $key)->get()->map(function($row){ $row->delete(); });
    }
}
