<?php
namespace Ariadne\Engine\ElasticSearch\Mapper;

use Zend\Http\Response;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Response\Result;
use Ariadne\Response\Result\HitCollection;
use Ariadne\Response\Result\Hit;

/**
 * Response mapper implementation for ElasticSearch
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ResultMapper
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Client\Mapper.ResponseMapper::map()
     */
    public function map(Response $response, ClassMetadata $metadata, $proxyFactory = null)
    {
        $className = $metadata->getClassName();
        $result = new Result();
        $foreign = json_decode($response->getBody());

        $result->setTotal($foreign->hits->total);

        foreach ($foreign->hits->hits as $foreignHit) {
            $hit = new Hit();
            if ($proxyFactory) {
                $hit->_proxy = $proxyFactory->getProxy($metadata->getClassName(), $foreignHit->_id);
            }

            $hit->setScore($foreignHit->_score);
            $hit->setDocument($foreignHit->_source);
            $result->getHits()->add($hit);
        }

        return $result;
    }
}