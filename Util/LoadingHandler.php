<?php

namespace Skillberto\Component\Config\Util;

class LoadingHandler implements LoadingHandlerInterface
{
    /**
     * @var callable
     */
    private $callback = null;

    /**
     * @var array
     */
    private $data = [];

    /**
     * {@inheritdoc}
     */
    public function addCallback(\Closure $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCallback()
    {
        return $this->callback ?: $this->createCallback();
    }

    /**
     * {@inheritdoc}
     */
    public function addData($data)
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return callable
     */
    protected function createCallback()
    {
        return function ($row) use ($this) {
            $this->data[] = $row;
        };
    }
}