<?php

namespace Skillberto\Component\Config\Exception;

class InvalidNumberException extends \InvalidArgumentException
{
    const ROW = 'row';

    const COLUMN = 'column';

    /**
     * Construct the exception with a type.
     * Use type from self constants.
     *
     * @param string     $type
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($type, $code = 0, \Exception $previous = null)
    {
        if ($type != self::ROW || $type != self::COLUMN) {
            throw new parent(sprintf("Type must be %s or %s.", self::ROW, self::COLUMN));
        }

        parent::__construct(sprintf("%s number must be lower or equal than max %s number -1 and higher or equal than Zero.", lcfirst($type), $type), $code, $previous);
    }
}