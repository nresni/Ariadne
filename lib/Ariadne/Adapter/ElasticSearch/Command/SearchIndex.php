<?php
namespace Ariadne\Adapter\ElasticSearch\Command;

use Zend\Http\Response;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Query\Sort;
use Ariadne\Query\Query;
use Ariadne\Response\Result;
use Ariadne\Response\Result\HitCollection;
use Ariadne\Response\Result\Hit;
use Ariadne\Adapter\Command;

/**
 * Create an index with zend lucene
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class SearchIndex extends Command
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Engine.Engine::search()
     */
    public function run(ClassMetadata $metadata, Query $query)
    {
        $index = $metadata->getIndex()->getName();

        $type = $metadata->getClassName();

        $query = $this->mapQuery($query);

        $response = $this->adapter->getClient()->search($index, $type, $query);

        return $this->mapResult($response, $metadata);
    }

    /**
     * Transforms a generic Query object into an Elastic Search query DSL
     *
     * @param Query $query
     */
    public function mapQuery(Query $query)
    {
        $map['from'] = $query->getOffset();
        $map['size'] = $query->getLimit();

        if ($query->hasQueryString()) {
            $map['query']['query_string'] = array();
            $map['query']['query_string']['query'] = $query->getQueryString()->getQuery();
            $map['query']['query_string']['default_field'] = $query->getQueryString()->getDefaultField();
            $map['query']['query_string']['default_operator'] = $query->getQueryString()->getDefaultOperator() == Query::OPERATOR_AND ? 'and' : 'or';
        }

        foreach ($query->getSort() as $sort) {
            $map['sort'][] = $sort;
        }

        return $map;
    }


    /**
     * Transform the raw http response into a Generic Result object
     *
     * @param Response $response
     * @param ClassMetadata $metadata
     * @return Result
     */
    public function mapResult(Response $response, ClassMetadata $metadata)
    {
        $className = $metadata->getClassName();
        $result = new Result();
        $foreign = json_decode($response->getBody());

        $result->setTotal($foreign->hits->total);
        foreach ($foreign->hits->hits as $foreignHit) {
            $hit = new Hit();
            $hit->setScore($foreignHit->_score);
            $hit->setDocument($foreignHit->_source);
            $result->getHits()->add($hit);
        }

        return $result;
    }
}