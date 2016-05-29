<?php

namespace Skillberto\Component\Config\Loader;

interface CallbackLoaderInterface
{
    /**
     * Add callable callback
     *
     * @param callable $callback
     *
     * @return $this Self object
     */
    public function addCallback(\Closure $callback);

    /**
     * Get the callable callback
     *
     * @return callable
     */
    public function getCallback();
}