<?php

namespace KnightAR\Laravel\Config\Storage;

/**
 * Storage Interface
 *
 * @package KnightAR\Laravel\Config\Storage
 */
interface StorageInterface
{
    /**
     * Save the specific key & value
     *
     * @param string $key
     * @param string|array $value
     * @return void
     */
    public function save($key, $value);

    /**
     * Forget a specific key
     *
     * @param string $key
     * @return void
     */
    public function forget($key);

    /**
     * Load all of the values from storage
     *
     * @return array
     */
    public function load();

    /**
     * Clear all of the collected config
     *
     * @return void
     */
    public function clear();
}
