<?php
namespace Ariadne\Driver;

/**
 * The mapper factory is used to lazy instanciate mappers.
 * Mappers are generic object that transforms generic objects
 * into an array definition that will be formatted inside the
 * request
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
abstract class BaseDriver implements Driver
{
    /**
     * @var array mappers
     */
    protected $mappers = array();

    /**
     * @var array options
     */
    protected $options = array();


    /**
     * Get a mapper instance
     *
     * @param string $mapper
     * @return Mapper $mapper
     */
    public function getMapper($mapper)
    {
        if (true === isset($this->mappers[$mapper])) {
            return $this->mappers[$mapper];
        }

        if (false === isset($this->options[$mapper])) {
            throw new \InvalidArgumentException("Unknown mapper $mapper");
        }

        $class = $this->options[$mapper];

        $this->mappers[$mapper] = new $class();

        return $this->mappers[$mapper];
    }

}