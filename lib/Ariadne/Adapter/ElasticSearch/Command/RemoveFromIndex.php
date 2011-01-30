<?php
namespace Ariadne\Adapter\ElasticSearch\Command;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Adapter\Command;

/**
 * Create an index with zend lucene
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class RemoveFromIndex extends Command
{
    /**
     * Transforms given objects into a bulk add operation directive
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @param array bulk commands
     */
    public function run(ClassMetadata $metadata, array $objects)
    {
        $data = $this->createBulk($metadata, $objects);

        return $this->adapter->getClient()->bulk($data);
    }

    /**
     * Transforms given objects into a bulk delete operation
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @return array bulk commands
     */
    public function createBulk(ClassMetadata $metadata, array $objects)
    {
        $index = $metadata->getIndex();

        $idGetter = 'get' . self::camelize($index->getIdProperty());
        $map = array();
        foreach ($objects as $object) {
            $map[] = array('delete' => array('_index' => $index->getName(), '_type' => $metadata->getClassName(), '_id' => $object->$idGetter()));
        }

        return $map;
    }
}