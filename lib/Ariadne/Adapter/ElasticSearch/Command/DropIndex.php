<?php
namespace Ariadne\Adapter\ElasticSearch\Command;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Adapter\Command;

/**
 * Create an index with zend lucene
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class DropIndex extends Command
{
    /**
     * Transforms given objects into a bulk add operation directive
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @param array bulk commands
     */
    public function run(ClassMetadata $metadata)
    {
        $indexName = $metadata->getIndex()->getName();

        return $this->driver->getClient()->dropIndex($indexName);
    }
}