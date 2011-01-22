<?php
namespace Ariadne\Client;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ElasticSearchClient extends BaseClient
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::search()
     */
    public function search($index, $type, array $query)
    {
        $this->httpClient->setUri("http://localhost:9200/$index/$type/_search");

        $data = json_encode($query);

        $this->httpClient->setRawData($data);

        return $this->httpClient->request('GET');
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::createIndex()
     */
    public function createIndex($index, array $mapping)
    {
        $this->httpClient->setUri("http://localhost:9200/$index");

        $mapping = json_encode($mapping);

        $this->httpClient->setRawData($mapping);

        return $this->httpClient->request('PUT');
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::dropIndex()
     */
    public function dropIndex($index)
    {
        $this->httpClient->setUri("http://localhost:9200/$index");

        return $this->httpClient->request('DELETE');
    }

    /**
     * Performs a bulk operation on the index.
     *
     * @param string $action
     * @param ClassMetadata $metadata
     * @param array $objects
     */
    public function bulk(array $data)
    {
        $this->httpClient->setUri("http://localhost:9200/_bulk");

        $definition = '';

        foreach ($data as $line) {
            $definition .= json_encode($line) . "\n";
        }

        $this->httpClient->setRawData($definition);

        return $this->httpClient->request('PUT');
    }
}