<?php
namespace Ariadne\Driver;

use Zend\Search\Lucene\Lucene;

use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ZendLuceneDriver extends BaseDriver
{
    /**
     * @var array options
     */
    protected $options = array(
      'result' => 'Ariadne\Driver\ZendLucene\ResultMapper',
      'query'  => 'Ariadne\Driver\ZendLucene\QueryMapper',
      'index'  => 'Ariadne\Driver\ZendLucene\IndexMapper',
      'schema' => 'Ariadne\Driver\ZendLucene\SchemaMapper');

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::search()
     */
    public function search(ClassMetadata $metadata, Query $query)
    {
        $index = $metadata->getIndex()->getName();

        $type = $metadata->getClassName();

        $query = $this->getMapper('query')->map($query);

        $index = Lucene::open("/tmp/index_$index");

        $response = $index->find($query);

        return $this->getMapper('result')->map($response, $metadata);
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::addToIndex()
     */
    public function addToIndex(ClassMetadata $metadata, array $objects)
    {
        $index = $metadata->getIndex()->getName();

        $index = Lucene::open("/tmp/index_$index");

        $documents = $this->getMapper('index')->add($metadata, $objects);

        foreach ($documents as $document) {
            $index->addDocument($document);
        }
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.Client::removeFromIndex()
     */
    public function removeFromIndex(ClassMetadata $metadata, array $objects)
    {
        throw new \BadMethodCallException('not yet implemented');
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::createIndex()
     */
    public function createIndex(ClassMetadata $metadata)
    {
        $index = $metadata->getIndex()->getName();

        Lucene::create("/tmp/index_$index");
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::dropIndex()
     */
    public function dropIndex(ClassMetadata $metadata)
    {
        $index = $metadata->getIndex()->getName();

        @unlink("/tmp/index_$index");
    }
}