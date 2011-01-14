<?php
namespace Ariadne;

use Ariadne\Client\Client;
use Ariadne\Query\Mapper;
use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadataFactory;

/**
 * Search manager
 *
 * @author dstendardi
 */
class SearchManager
{
    /**
     * Used to retrieve mapping
     *
     * @var ClassMetadataFactory $mapping
     */
    protected $mapping;

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var ProxyFactory
     */
    protected $proxyFactory;

    /**
     * @var array objects
     */
    protected $insertions = array();

    /**
     * @var array objects
     */
    protected $deletions = array();

    /**
     * Set required dependencies
     *
     * @param ClassMetadataFactory $mapping
     * @param Client http client
     */
    public function __construct(ClassMetadataFactory $mapping, Client $client)
    {
        $this->mapping = $mapping;

        $this->client = $client;
    }

    /**
     * Create a new query instance
     *
     * @param string class name
     * @return Query $query
     */
    public function createQuery($className)
    {
        return new Query($this, $className);
    }

    /**
     * Create an index using the fully qualified class name
     *
     * @param string class name
     * @return Response $response
     */
    public function createIndex($className)
    {
        $metadata = $this->mapping->getClassMetadata($className);

        return $this->client->createIndex($metadata);
    }

    /**
     * Drop an index using the fully qualified class name
     *
     * @param string class name
     * @return Response $response
     */
    public function dropIndex($className)
    {
        $metadata = $this->mapping->getClassMetadata($className);

        return $this->client->dropIndex($metadata);
    }

    /**
     * @param \stdClass $object
     */
    public function addToIndex($object)
    {
        $this->insertions[get_class($object)][] = $object;
    }

    /**
     * @param \stdClass object
     */
    public function removeFromIndex($object)
    {
        $this->deletions[get_class($object)][] = $object;
    }

    /**
     * Performs pending operations
     */
    public function flush()
    {
        foreach($this->insertions as $class => $objects)
        {
            $metadata = $this->mapping->getClassMetadata($class);

            $this->client->addToIndex($metadata, $objects);
        }

        $this->insertions = array();

        foreach($this->deletions as $class => $objects)
        {
            $metadata = $this->mapping->getClassMetadata($class);

            $this->client->removeFromIndex($metadata, $objects);
        }

        $this->deletions = array();
    }

    /**
     * Executes a query against the given class name's index
     *
     * @param string class name
     * @return Response $response
     */
    public function search(Query $query)
    {
        $metadata = $this->mapping->getClassMetadata($query->getClassName());

        return $this->client->search($metadata, $query, $this->proxyFactory);
    }

    /**
     * @param mixed $proxyFactory
     */
    public function setProxyFactory($proxyFactory)
    {
        $this->proxyFactory = $proxyFactory;
    }
}