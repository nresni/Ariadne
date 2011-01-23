<?php
namespace Ariadne\Driver;

use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;

/**
 * The mapper factory is used to lazy instanciate mappers.
 * Mappers are generic object that transforms generic objects
 * into an array definition that will be formatted inside the
 * request
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
abstract class BaseDriver
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
     * Search inside the index & type configured in the metadata
     * and returns a generic result object
     *
     * @param ClassMetadata $metadata
     * @param Query $query
     * @return Result
     */
    abstract public function search(ClassMetadata $metadata, Query $query);

    /**
     * Creates the index configured in the given class metadata
     *
     * @param ClassMetadata $metadata
     */
    abstract public function createIndex(ClassMetadata $metadata);

    /**
     * Drops the index configured in the given class metadata
     *
     * @param ClassMetadata $metadata
     */
    abstract public function dropIndex(ClassMetadata $metadata);

    /**
     * Add given objects to the index
     *
     * @param ClassMetadata $metadata
     * @param array objects
     */
    abstract public function addToIndex(ClassMetadata $metadata, array $objects);

    /**
     *  Removes the given objects from the index
     *
     * @param ClassMetadata $metadata
     * @param array objects
     */
    abstract public function removeFromIndex(ClassMetadata $metadata, array $objects);

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