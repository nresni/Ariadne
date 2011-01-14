<?php
namespace Ariadne\Client\ElasticSearch\Mapper;

use Ariadne\Query\Sort;
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
        $map['from'] = $query->getOffset();
        $map['size'] = $query->getLimit();

        if ($query->hasQueryString()) {
            $map['query']['query_string'] = array();
            $map['query']['query_string']['query'] = $query->getQueryString()->getQuery();
            $map['query']['query_string']['default_field'] = $query->getQueryString()->getDefaultField();
        }

        foreach ($query->getSort() as $field => $direction) {
            $map['sort'][] = array($field => $direction);
        }

        return $map;
    }
}