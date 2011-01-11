<?php
namespace Ariadne\Client;

use Zend\Http\Client as HttpClient;
use Ariadne\Client\Mapper\ResponseMapper;
use Ariadne\Client\Mapper\QueryMapper;
use Ariadne\Client\Mapper\IndexMapper;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Query\Query;
use Ariadne\Response\Result;

/**
 * Base class for search abstraction layer
 * Delegates index creation / dropping / search definition translations to the specific
 * mapper objects
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
abstract class Client
{
    /**
     * @var QueryMapper
     */
    protected $queryMapper;

    /**
     * @var ResultMapper
     */
    protected $responseMapper;

    /**
     * Http client
     *
     * @var Client $client
     */
    protected $httpClient;

    /**
     * @var IndexMapper
     */
    protected $indexMapper;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(HttpClient $httpClient, IndexMapper $indexMapper, QueryMapper $queryMapper, ResponseMapper $responseMapper)
    {
        $this->httpClient = $httpClient;

        $this->indexMapper = $indexMapper;

        $this->queryMapper = $queryMapper;

        $this->responseMapper = $responseMapper;
    }

    /**
     * Search inside the index & type configured in the metadata
     * and returns a generic result object
     *
     * @param ClassMetadata $metadata
     * @param Query $query
     * @return Result
     */
    abstract public function search(ClassMetadata $metadata, Query $query, $proxyFactory = null);

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
}