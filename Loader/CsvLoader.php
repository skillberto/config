<?php

namespace Skillberto\Component\Config\Loader;

use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Symfony\Component\Config\Loader\FileLoader;

class CsvLoader extends FileLoader implements CallbackLoaderInterface
{
    private $callback = null;

    /**
     * Insert callback for interpreter
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function addCallback(\Closure $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        $config = new LexerConfig();
        $lexer = new Lexer($config);

        $interpreter = new Interpreter();

        $data = array();

        $interpreter->addObserver($this->callback ?: function(array $columns) use (&$data) {
            $data[] = $columns;
        });

        $lexer->parse($resource, $interpreter);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'csv' === pathinfo($resource, PATHINFO_EXTENSION);
    }
}