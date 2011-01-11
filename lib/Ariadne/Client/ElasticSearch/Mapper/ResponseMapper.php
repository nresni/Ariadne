<?php
namespace Ariadne\Client\ElasticSearch\Mapper;

use Zend\Http\Response;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Response\Result;
use Ariadne\Response\Result\HitCollection;
use Ariadne\Response\Result\Hit;
use Ariadne\Client\Mapper\ResponseMapper as BaseResponseMapper;

/**
 * Maps the specific result object to the generic one
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class ResponseMapper implements BaseResponseMapper
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

        foreach ($foreign->hits->hits as $foreignHit) {

            $hit = new Hit();

            if ($proxyFactory) {
                $hit->_proxy = $proxyFactory->getProxy($metadata->getClassName(), $foreignHit->_id);

            }

            $hit = $this->mapHit($metadata, $foreignHit->_source, $hit, $proxyFactory);

            $result->getHits()->add($hit);
        }

        return $result;
    }

    /**
     *
     */
    protected function mapHit(ClassMetadata $metadata, $object, $parent, $proxyFactory = null)
    {
        foreach ($metadata->getFields() as $field) {
            $key = $field->getIndexName();
            $parent->$key = $object->$key;
        }
        foreach ($metadata->getEmbeds() as $name => $embed) {
            $embedMetadata = $metadata->getEmbeddedMetadata($name);
            if (isset($object->$name)) {
                $parent->$name = $this->mapHit($embedMetadata, $object->$name, new \stdClass());
            }
        }

        return $parent;
    }

}