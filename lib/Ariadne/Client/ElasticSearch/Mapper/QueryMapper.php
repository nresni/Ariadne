<?php
namespace Ariadne\Client\ElasticSearch\Mapper;

use Ariadne\Query\Query;
use Ariadne\Client\Mapper\QueryMapper as BaseQueryMapper;

/**
 * Maps the generic Query object to the Elastic search format.
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class QueryMapper implements BaseQueryMapper
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Client\Mapper.QueryMapper::map()
     */
    public function map(Query $query)
    {
        $map = array('query' => array());

        $queryString = $query->getQueryString();

        if ($queryString) {
            $map['query']['query_string'] = array();
            $map['query']['query_string']['query'] = $queryString->getQuery();
            $map['query']['query_string']['default_field'] = $queryString->getDefaultField();
        }

        return $map;
    }
}