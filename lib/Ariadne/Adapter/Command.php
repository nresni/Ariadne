<?php
namespace Ariadne\Adapter;

class Command
{
    /**
     * The driver which instanciate the commands
     *
     * @var Adapter $adapter
     */
    protected $adapter;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}