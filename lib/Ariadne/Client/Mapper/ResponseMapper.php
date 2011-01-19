<?php
namespace Ariadne\Client\Mapper;

use Zend\Http\Response;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Response\Result;
use Ariadne\Query\Query;

/**
 * Response Mapper
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
interface ResponseMapper
{
    /**
     * Map the response to the generic response object
     *
     * @param Query $query
     * @param ClassMetadata
     * @param mixed ProxyFactory
     * @return Result mapped
     */
    public function map(Response $response, ClassMetadata $metadata, $proxyFactory = null);
}