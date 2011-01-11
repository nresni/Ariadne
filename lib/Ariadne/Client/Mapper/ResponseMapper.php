<?php
namespace Ariadne\Client\Mapper;

use Zend\Http\Response;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Response\Result;
use Ariadne\Query\Query;

interface ResponseMapper
{
    /**
     * Map the query object to the vendor's expected format
     *
     * @param Query $query
     * @param ClassMetadata
     * @param mixed ProxyFactory
     * @return Result mapped
     */
    public function map(Response $response, ClassMetadata $metadata, $proxyFactory = null);
}