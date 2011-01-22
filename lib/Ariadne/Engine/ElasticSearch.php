<?php
namespace Ariadne\Engine;

use Ariadne\Engine\ElasticSearch\MapperFactory;

use Zend\Http\Client as HttpClient;

use Ariadne\Client\Client;
use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Engine\ElasticSearch\ResponseMapper;
use Ariadne\Engine\ElasticSearch\QueryMapper;
use Ariadne\Engine\ElasticSearch\IndexMapper;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ElasticSearch implements Engine
{
    /**
     * Http client
     *
     * @var Client $client
     */
    protected $httpClient;

    /**
     * Mapper factory
     *
     * @var MapperFactory
     */
    protected $mapperFactory;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(HttpClient $httpClient, MapperFactory $mapperFactory)
    {
        $this->httpClient = $httpClient;

        $this->mapperFactory = $mapperFactory;
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::search()
     */
    public function search(ClassMetadata $metadata, Query $query, $proxyFactory = null)
    {
        $indexName = $metadata->getIndex()->getName();

        $typeName = $metadata->getClassName();

        $this->httpClient->setUri("http://localhost:9200/$indexName/$typeName/_search");

        $query = $this->mapperFactory->get('query')->map($query);

        $data = json_encode($query);

        $this->httpClient->setRawData($data);

        $response = $this->httpClient->request('GET');

        return $this->mapperFactory->get('result')->map($response, $metadata, $proxyFactory);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::addToIndex()
     */
    public function addToIndex(ClassMetadata $metadata, array $objects)
    {
        return $this->bulk('add', $metadata, $objects);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.Client::removeFromIndex()
     */
    public function removeFromIndex(ClassMetadata $metadata, array $objects)
    {
        return $this->bulk('remove', $metadata, $objects);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::createIndex()
     */
    public function createIndex(ClassMetadata $metadata)
    {
        $indexName = $metadata->getIndex()->getName();

        $this->httpClient->setUri("http://localhost:9200/$indexName");

        $definition = $this->mapperFactory->get('schema')->map($metadata);

        $data = json_encode($definition);

        $this->httpClient->setRawData($data);

        return $this->httpClient->request('PUT');
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::dropIndex()
     */
    public function dropIndex(ClassMetadata $metadata)
    {
        $indexName = $metadata->getIndex()->getName();

        $this->httpClient->setUri("http://localhost:9200/$indexName");

        return $this->httpClient->request('DELETE');
    }

    /**
     * Performs a bulk operation on the index.
     *
     * @param string $action
     * @param ClassMetadata $metadata
     * @param array $objects
     */
    protected function bulk($action, ClassMetadata $metadata, array $objects)
    {
        $this->httpClient->setUri("http://localhost:9200/_bulk");

        $data = $this->mapperFactory->get('index')->$action($metadata, $objects);

        $definition = '';

        foreach ($data as $line) {
            $definition .= json_encode($line) . "\n";
        }

        $this->httpClient->setRawData($definition);

        return $this->httpClient->request('PUT');
    }
}