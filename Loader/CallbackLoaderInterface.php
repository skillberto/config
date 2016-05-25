<?php

namespace Skillberto\Component\Config\Loader;

interface CallbackLoaderInterface
{
    public function addCallback(\Closure $callback);
}