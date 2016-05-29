<?php

namespace Skillberto\Component\Config\Loader;
use Skillberto\Component\Config\Exception\InvalidNumberException;

/**
 * Interface TableLoaderInterface
 *
 * @package Skillberto\Component\Config\Loader
 */
interface TableLoaderInterface
{
    /**
     * Return the whole rows
     *
     * @return array
     */
    public function getRows();

    /**
     * Return the whole columns.
     * If loaded the handler, then persist cache
     *
     *
     * @return array
     */
    public function getColumns();

    /**
     * Return a given row.
     *
     * @param int $num Started from Zero.
     *
     * @return array An array of columns.
     * 
     * @throws InvalidNumberException
     */
    public function getRow($num = 0);

    /**
     * Return a given column.
     *
     * @param int $num Started from Zero.
     *
     * @return array An array of rows.
     *
     * @throws InvalidNumberException
     */
    public function getColumn($num = 0);
}