<?php
namespace Ariadne\Engine\ElasticSearch\Mapper;

use Zend\Http\Response;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Response\Result;
use Ariadne\Response\Result\HitCollection;
use Ariadne\Response\Result\Hit;

/**
 * ResultMapper
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ResultMapper
{
    /**
     * Transform the raw http response into a Generic Result object
     *
     * @param Response $response
     * @param ClassMetadata $metadata
     * @return Result
     */
    public function map(Response $response, ClassMetadata $metadata)
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