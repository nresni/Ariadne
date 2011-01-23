<?php
namespace Ariadne\Driver;

class Command
{
    /**
     * The driver which instanciate the commands
     *
     * @var Driver $driver
     */
    protected $driver;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }
}