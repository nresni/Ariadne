<?php
namespace Ariadne\Driver\ElasticSearch;

use Ariadne\Query\Sort;
use Ariadne\Query\Query;

/**
 * QueryMapper
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class QueryMapper
{
    /**
     * Transforms a generic Query object into an Elastic Search query DSL
     *
     * @param Query $query
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