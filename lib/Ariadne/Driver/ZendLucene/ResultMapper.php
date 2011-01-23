<?php
namespace Ariadne\Driver\ZendLucene;

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
    public function map(array $foreignResult, ClassMetadata $metadata)
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