<?php
namespace Ariadne\Driver\ZendLucene;

use Zend\Search\Lucene\Search\Query\Boolean;

use Zend\Search\Lucene\Search\QueryParser;

use Zend\Search\Lucene\Lucene;

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
        $map = new Boolean();

        if ($query->hasQueryString()) {

            Lucene::setDefaultSearchField($query->getQueryString()->getDefaultField());

            QueryParser::setDefaultOperator($query->getQueryString()->getDefaultOperator());

            $map->addSubquery(QueryParser::parse($query->getQueryString()->getQuery()), true);
        }

        Lucene::setResultSetLimit($query->getLimit());

        return $map;
    }
}