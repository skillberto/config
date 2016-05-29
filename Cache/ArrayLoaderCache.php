<?php

namespace Skillberto\Component\Config\Cache;

use Skillberto\Component\Config\Exception\InvalidKeyException;

class ArrayLoaderCache implements LoaderCacheInterface
{
    /**
     * @var array
     */
    private $data;

    public function __construct()
    {
        $this->erase();
    }

    /**
     * {@inheritdoc)
     */
    public function set($key, $value)
    {
        $this->data[(string) $key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc)
     */
    public function get($key)
    {
        if (! array_key_exists((string) $key, $this->data)) {
            return null;
        }

        return $this->data[(string) $key];
    }

    /**
     * {@inheritdoc)
     */
    public function erase()
    {
        $this->data = [];

        return $this;
    }
}