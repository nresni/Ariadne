<?php
namespace Ariadne\Client\Mapper;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Query\Query;

/**
 * Index Mapper
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
interface IndexMapper
{
    /**
     * Transforms metadata into a definition for the vendor api create index / mapping operation
     *
     * @param ClassMetadata $metadata
     * @return array mapped
     */
    public function create(ClassMetadata $metadata);


    /**
     * Transforms metadata into a definition for the vendor api add operation
     *
     * @param ClassMetadata $metadata
     * @param array objects
     */
    public function add(ClassMetadata $metadata, array $objects);


    /**
     * Transforms metadata to a definition for the vendor api remove operation
     *
     * @param ClassMetadata $metadata
     * @param array objects
     */
    public function remove(ClassMetadata $metadata, array $objects);
}