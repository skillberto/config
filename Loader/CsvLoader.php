<?php

namespace Skillberto\Component\Config\Loader;

use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Skillberto\Component\Config\Cache\LoaderCacheInterface;
use Skillberto\Component\Config\Util\LoadingHandlerInterface;
use Symfony\Component\Config\FileLocatorInterface;

class CsvLoader extends TableLoader
{
    protected $lexerConfig = null;

    protected $interpreter;

    /**
     * @param FileLocatorInterface         $locator
     * @param LexerConfig|null             $lexerConfig
     * @param LoadingHandlerInterface|null $loadingHandler
     * @param LoaderCacheInterface|null    $loaderCacheInterface
     */
    public function __construct(FileLocatorInterface $locator, LexerConfig $lexerConfig = null, LoadingHandlerInterface $loadingHandler = null, LoaderCacheInterface $loaderCacheInterface = null)
    {
        parent::__construct($locator, $loadingHandler, $loaderCacheInterface);

        $this->lexerConfig = $lexerConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        $lexer = new Lexer($this->lexerConfig);

        $interpreter = new Interpreter();

        $interpreter->addObserver($this->getCallback());

        $lexer->parse($resource, $interpreter);

        $this->loaded = true;

        return $this->getRows();
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'csv' === pathinfo($resource, PATHINFO_EXTENSION);
    }
}