<?php
namespace Ariadne\Client\Mapper;

use Ariadne\Mapping\ClassMetadata;

use Ariadne\Query\Query;

/**
 * Maps the metadata to the elastic search expected formats.
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
interface IndexMapper
{
    /**
     * Map the query object to the vendor's expected format
     *
     * @param Query $query
     * @return array mapped
     */
    public function create(ClassMetadata $metadata);


    /**
     * @param ClassMetadata
     * @param Mixed objects
     */
    public function add(ClassMetadata $metadata, array $objects);


    /**
     * @param ClassMetadata
     * @param Mixed objects
     */
    public function remove(ClassMetadata $metadata, array $objects);
}