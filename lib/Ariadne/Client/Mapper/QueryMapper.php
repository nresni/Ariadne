<?php
namespace Ariadne\Client\Mapper;

use Ariadne\Query\Query;

interface QueryMapper
{
    /**
     * Map the query object to the vendor's expected format
     *
     * @param Query $query
     * @return array mapped
     */
    public function map(Query $query);
}