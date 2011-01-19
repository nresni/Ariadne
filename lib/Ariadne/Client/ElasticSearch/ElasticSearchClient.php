<?php
namespace Ariadne\Client\ElasticSearch;

use Ariadne\Client\Client;
use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ElasticSearchClient extends Client
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.AbstractClient::search()
     */
    public function search(ClassMetadata $metadata, Query $query, $proxyFactory = null)
    {
        $indexName = $metadata->getIndex()->getName();

        $typeName = $metadata->getClassName();

        $this->httpClient->setUri("http://localhost:9200/$indexName/$typeName/_search");

        $query = $this->queryMapper->map($query);

        $data = json_encode($query);

        $this->httpClient->setRawData($data);

        $response = $this->httpClient->request('GET');

        return $this->responseMapper->map($response, $metadata, $proxyFactory);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.Client::addToIndex()
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
     * @see Ariadne\Client.AbstractClient::createIndex()
     */
    public function createIndex(ClassMetadata $metadata)
    {
        $indexName = $metadata->getIndex()->getName();

        $this->httpClient->setUri("http://localhost:9200/$indexName");

        $definition = $this->indexMapper->create($metadata);

        $data = json_encode($definition);

        $this->httpClient->setRawData($data);

        return $this->httpClient->request('PUT');
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.AbstractClient::dropIndex()
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

        $data = $this->indexMapper->$action($metadata, $objects);

        $definition = '';

        foreach ($data as $line) {
            $definition .= json_encode($line) . "\n";
        }

        $this->httpClient->setRawData($definition);

        return $this->httpClient->request('PUT');
    }
}