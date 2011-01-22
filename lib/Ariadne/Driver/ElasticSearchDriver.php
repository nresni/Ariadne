<?php
namespace Ariadne\Driver;

use Zend\Http\Client as HttpClient;

use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Engine\MapperFactory;
use Ariadne\Client\ElasticSearchClient;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ElasticSearchDriver extends BaseDriver
{
    /**
     * search client
     *
     * @var ElasticSearchEngine $client
     */
    protected $client;

    /**
     * @var array options
     */
    protected $options = array(
        'result' => 'Ariadne\Driver\ElasticSearch\ResultMapper',
        'query'  => 'Ariadne\Driver\ElasticSearch\QueryMapper',
        'index'  => 'Ariadne\Driver\ElasticSearch\IndexMapper',
        'schema' => 'Ariadne\Driver\ElasticSearch\SchemaMapper'
        );

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(ElasticSearchClient $client)
    {
        $this->client = $client;
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::search()
     */
    public function search(ClassMetadata $metadata, Query $query)
    {
        $index = $metadata->getIndex()->getName();

        $type = $metadata->getClassName();

        $query = $this->getMapper('query')->map($query);

        $response = $this->client->search($index, $type, $query);

        return $this->getMapper('result')->map($response, $metadata);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::addToIndex()
     */
    public function addToIndex(ClassMetadata $metadata, array $objects)
    {
        $data = $this->getMapper('index')->add($metadata, $objects);

        return $this->client->bulk($data);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.Client::removeFromIndex()
     */
    public function removeFromIndex(ClassMetadata $metadata, array $objects)
    {
        $data = $this->getMapper('index')->remove($metadata, $objects);

        return $this->client->bulk($data);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::createIndex()
     */
    public function createIndex(ClassMetadata $metadata)
    {
        $indexName = $metadata->getIndex()->getName();

        $definition = $this->getMapper('schema')->map($metadata);

        return $this->client->createIndex($indexName, $definition);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::dropIndex()
     */
    public function dropIndex(ClassMetadata $metadata)
    {
        $indexName = $metadata->getIndex()->getName();

        return $this->client->dropIndex($indexName);
    }
}