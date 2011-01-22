<?php
namespace Ariadne\Driver;

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
interface Driver
{
    /**
     * Search inside the index & type configured in the metadata
     * and returns a generic result object
     *
     * @param ClassMetadata $metadata
     * @param Query $query
     * @return Result
     */
    public function search(ClassMetadata $metadata, Query $query);

    /**
     * Creates the index configured in the given class metadata
     *
     * @param ClassMetadata $metadata
     */
    public function createIndex(ClassMetadata $metadata);

    /**
     * Drops the index configured in the given class metadata
     *
     * @param ClassMetadata $metadata
     */
    public function dropIndex(ClassMetadata $metadata);

    /**
     * Add given objects to the index
     *
     * @param ClassMetadata $metadata
     * @param array objects
     */
    public function addToIndex(ClassMetadata $metadata, array $objects);

    /**
     *  Removes the given objects from the index
     *
     * @param ClassMetadata $metadata
     * @param array objects
     */
    public function removeFromIndex(ClassMetadata $metadata, array $objects);
}