<?php
namespace Ariadne\Adapter;

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
abstract class Adapter
{
    /**
     * @var array mappers
     */
    protected $commands = array();

    /**
     * @return String Adapter name
     */
    abstract public function getName();

    /**
     * @return Array a list of available commands
     */
    abstract public function getAvailableCommands();

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::search()
     */
    public function search(ClassMetadata $metadata, Query $query)
    {
        return $this->getCommand('SearchIndex')->run($metadata, $query);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::addToIndex()
     */
    public function addToIndex(ClassMetadata $metadata, array $objects)
    {
        return $this->getCommand('AddToIndex')->run($metadata, $objects);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.Client::removeFromIndex()
     */
    public function removeFromIndex(ClassMetadata $metadata, array $objects)
    {
        return $this->getCommmand('RemoveFromIndex')->run($metadata, $objects);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::createIndex()
     */
    public function createIndex(ClassMetadata $metadata)
    {
        return $this->getCommand('CreateIndex')->run($metadata);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::dropIndex()
     */
    public function dropIndex(ClassMetadata $metadata)
    {
        return $this->getCommand('DropIndex')->run($metadata);
    }

    /**
     * Get a mapper instance
     *
     * @param string $command
     * @return Mapper $command
     */
    public function getCommand($command)
    {
        if (true === isset($this->commands[$command])) {
            return $this->commands[$command];
        }

        $commandMap = $this->getAvailableCommands();

        if (false === isset($commandMap[$command])) {
            throw new \InvalidArgumentException("Unknown command $command");
        }

        $class = $commandMap[$command];

        $this->commands[$command] = new $class($this);

        return $this->commands[$command];
    }
}