<?php
namespace Ariadne\Driver\ZendLucene\Command;

use Ariadne\Driver\Command;

use Zend\Search\Lucene\Lucene;
use Ariadne\Mapping\ClassMetadata;

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
        throw new \BadMethodCallException('not yet implemented');
    }
}