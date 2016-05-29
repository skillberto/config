<?php

namespace Skillberto\Component\Config\Cache;

use Skillberto\Component\Config\Exception\InvalidKeyException;

interface LoaderCacheInterface
{
    /**
     * Set the cache value by their key
     * With the key you can access them.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this Self object
     */
    public function set($key, $value);

    /**
     * Return the content for the key or null if not exists
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key);

    /**
     * Erase the whole cache.
     *
     * @return $this Self object
     */
    public function erase();
}