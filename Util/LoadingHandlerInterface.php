<?php

namespace Skillberto\Component\Config\Util;

use Skillberto\Component\Config\Loader\CallbackLoaderInterface;

interface LoadingHandlerInterface extends CallbackLoaderInterface
{
    /**
     * Add the data to the handler
     *
     * @param mixed $data
     *
     * @return $this Self object
     */
    public function addData($data);

    /**
     * Return the whole data.
     * Every value will represent one row.
     *
     * @return array
     */
    public function getData();
}