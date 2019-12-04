<?php

namespace KnightAR\Laravel\Config\Storage;

use KnightAR\Laravel\Config\RunetimeConfig;

/**
 * Eloquent storage for config
 *
 * @package KnightAR\Laravel\Config\Storage
 */
class Eloquent implements StorageInterface
{
    /**
     * @inheritdoc
     */
    public function save($key, $value)
    {
        $this->delKey($key);

        if (is_array($value)) {
            foreach ($value as $i => $arrValue) {
                $this->saveKey($key.'['.$i.']', $arrValue);
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
     * @param  string $key
     * @param  string|int|float $value
     */
    private function saveKey($key, $value)
    {
        return RunetimeConfig::updateOrCreate($key, $value);
    }

    /**
     * @inheritdoc
     */
    public function load()
    {
        $results = [];
        foreach (RunetimeConfig::all() as $row) {
            $results[$row->key] = $row->value;
        }
        return $results;
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        RunetimeConfig::truncate();
    }

    /**
     * Delete the requested key from the database storage
     *
     * @param  string $key
     */
    private function delKey($key)
    {
        RunetimeConfig::where('key', $key)->delete();
    }
}
