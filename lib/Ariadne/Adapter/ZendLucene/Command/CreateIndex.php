<?php
namespace Ariadne\Adapter\ZendLucene\Command;

use Ariadne\Adapter\Command;

use Zend\Search\Lucene\Lucene;
use Ariadne\Mapping\ClassMetadata;

/**
 * Create an index with zend lucene
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class CreateIndex extends Command
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
        $index = $metadata->getIndex()->getName();

        Lucene::create("/tmp/index_$index");
    }
}