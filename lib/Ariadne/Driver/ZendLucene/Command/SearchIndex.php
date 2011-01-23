<?php
namespace Ariadne\Driver\ZendLucene\Command;

use Zend\Search\Lucene\Search\Query\Boolean;
use Zend\Search\Lucene\Search\QueryParser;
use Zend\Search\Lucene\Lucene;
use Ariadne\Driver\Command;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Query\Sort;
use Ariadne\Query\Query;
use Ariadne\Response\Result;
use Ariadne\Response\Result\HitCollection;
use Ariadne\Response\Result\Hit;


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

        $response = Lucene::open("/tmp/index_$index")->find($query);

        return $this->mapResult($response, $metadata);
    }

    /**
     * Transforms a generic Query object into an Elastic Search query DSL
     *
     * @param Query $query
     */
    public function mapQuery(Query $query)
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


    /**
     * Transform the raw http response into a Generic Result object
     *
     * @param Response $response
     * @param ClassMetadata $metadata
     * @return Result
     */
    public function mapResult(array $foreignResult, ClassMetadata $metadata)
    {
        $className = $metadata->getClassName();

        $result = new Result();

        $result->setTotal(count($foreignResult));

        foreach ($foreignResult as $foreignHit) {

            $hit = new Hit();
            $hit->setScore($foreignHit->score);
            $hit->setDocument(json_decode($foreignHit->_doc));
            $result->getHits()->add($hit);
        }

        return $result;
    }
}