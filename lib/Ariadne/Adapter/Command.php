<?php
namespace Ariadne\Adapter;

class Command
{
    /**
     * The driver which instanciate the commands
     *
     * @var Adapter $driver
     */
    protected $driver;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(Adapter $driver)
    {
        $this->driver = $driver;
    }
}