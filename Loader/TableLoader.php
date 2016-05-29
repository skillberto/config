<?php

namespace Skillberto\Component\Config\Loader;

use Skillberto\Component\Config\Cache\ArrayLoaderCache;
use Skillberto\Component\Config\Cache\LoaderCacheInterface;
use Skillberto\Component\Config\Exception\InvalidNumberException;
use Skillberto\Component\Config\Util\LoadingHandler;
use Skillberto\Component\Config\Util\LoadingHandlerInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Loader\FileLoader;

abstract class TableLoader extends FileLoader implements TableLoaderInterface, CallbackLoaderInterface
{
    /**
     * @var LoadingHandlerInterface
     */
    private $loadingHandler = null;

    /**
     * @var LoaderCacheInterface
     */
    private $loaderCache;

    /**
     * @var bool
     */
    protected $loaded = true;

    /**
     * @param FileLocatorInterface    $locator
     * @param LoadingHandlerInterface $loadingHandler
     * @param LoaderCacheInterface    $loaderCacheInterface
     */
    public function __construct(FileLocatorInterface $locator, LoadingHandlerInterface $loadingHandler = null, LoaderCacheInterface $loaderCacheInterface = null)
    {
        parent::__construct($locator);

        $this->loadingHandler = $loadingHandler ?: new LoadingHandler();
        $this->loaderCache = $loaderCacheInterface ?: new ArrayLoaderCache();
    }

    /**
     * Insert callback for interpreter
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function addCallback(\Closure $callback)
    {
        $this->loadingHandler->addCallback($callback);

        return $this;
    }

    /**
     * Return the callback, and setup loaded to false, because callback used.
     * In this case you need to manually set $loaded to 'true' after the loading.
     *
     * @return callable
     */
    public function getCallback()
    {
        $this->loaded = false;

        return $this->loadingHandler->getCallback();
    }

    /**
     * Return the whole rows.
     * If loaded the handler, then persist cache, and use that
     *
     * @return array
     */
    public function getRows()
    {
        $data = $this->loaderCache->get('rows');

        if (null == $data) {
            $data = $this->loadingHandler->getData();

            if ($this->isLoaded()) {
                $this->loaderCache->set('rows', $data);
            }
        }

        return $data;
    }

    /**
     * Return the whole columns.
     * If loaded the handler, then persist cache, and use that
     *
     * @return array
     */
    public function getColumns()
    {
        $data = $this->loaderCache->get('columns');

        if (null == $data) {
            $data = $this->persistColumns();

            if ($this->isLoaded()) {
                $this->loaderCache->set('columns', $data);
            }
        }

        return $data;
    }

    /**
     * Return a given row.
     *
     * @param int $num Started from Zero.
     *
     * @return array An array of columns.
     *
     * @throws InvalidArgumentException
     */
    public function getRow($num = 0)
    {
        $rows = $this->getRows();

        if ((count($rows) - 1) < $num || $num < 0) {
            throw new InvalidNumberException(InvalidNumberException::ROW);
        }

        return $rows[$num];
    }

    /**
     * Return a given column.
     *
     * @param int $num Started from Zero.
     *
     * @return array An array of rows.
     *
     * @throws InvalidArgumentException
     */
    public function getColumn($num = 0)
    {
        $columns = $this->getColumns();

        if ((count($columns) - 1) < $num || $num < 0) {
            throw new InvalidNumberException(InvalidNumberException::COLUMN);
        }

        return $columns[$num];
    }

    /**
     * Cache loaded or not
     *
     * @return bool
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * @return array
     */
    protected function persistColumns()
    {
        $columns = [];

        $rows = $this->getRows();

        foreach ($rows as $row) {
            $columns[] = $row;
        }

        return $columns;
    }
}