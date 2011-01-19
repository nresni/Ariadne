<?php
namespace Ariadne\Client\ElasticSearch\Mapper;

use Ariadne\Query\Sort;
use Ariadne\Query\Query;
use Ariadne\Client\Mapper\QueryMapper as BaseQueryMapper;

/**
 * Query mapper implementation for ElasticSearch
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class QueryMapper implements BaseQueryMapper
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Client\Mapper.QueryMapper::map()
     */
    public function map(Query $query)
    {
        $map['from'] = $query->getOffset();
        $map['size'] = $query->getLimit();

        if ($query->hasQueryString()) {
            $map['query']['query_string'] = array();
            $map['query']['query_string']['query'] = $query->getQueryString()->getQuery();
            $map['query']['query_string']['default_field'] = $query->getQueryString()->getDefaultField();
            $map['query']['query_string']['default_operator'] = $query->getQueryString()->getDefaultOperator();
        }

        foreach ($query->getSort() as $sort) {
            $map['sort'][] = $sort;
        }

        return $map;
    }
}