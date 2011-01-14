<?php
namespace Ariadne\Tests\Unit\Client\ElasticSearch;

use Ariadne\Client\ElasticSearch\ElasticSearchClient;

/**
 * Exposer for the get file name method
 *
 * @author dstendardi
 */

class ElasticSearchClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->httpClient = $this->getMockBuilder('Zend\Http\Client')
        ->setMethods(array('setUri', 'setRawData', 'request'))
        ->getMock();

        $this->metadata = $this->getMockBuilder('Ariadne\Mapping\ClassMetadata')
        ->disableOriginalConstructor()
        ->setMethods(array('getIndex', 'getClassName'))
        ->getMock();

        $this->indexMapper = $this->getMockBuilder('Ariadne\Client\ElasticSearch\Mapper\IndexMapper')->getMock();

        $this->queryMapper = $this->getMockBuilder('Ariadne\Client\ElasticSearch\Mapper\QueryMapper')->getMock();

        $this->responseMapper = $this->getMockBuilder('Ariadne\Client\ElasticSearch\Mapper\ResponseMapper')->getMock();

        $this->client = new ElasticSearchClient($this->httpClient, $this->indexMapper, $this->queryMapper, $this->responseMapper);
    }

    /**
     * @test
     * @cover ElasticSearchClient::search
     */
    public function testSearch()
    {
        $index = $this->getMockBuilder('Ariadne\Mapping\Element\Index')
        ->disableOriginalConstructor()
        ->setMethods(array('getName'))
        ->getMock();

        $index->expects($this->once())
        ->method('getName')
        ->will($this->returnValue('foo'));

        $this->metadata->expects($this->once())
        ->method('getIndex')
        ->will($this->returnValue($index));

        $this->metadata->expects($this->once())
        ->method('getClassName')
        ->will($this->returnValue('bar'));

        $query = $this->getMockBuilder('Ariadne\Query\Query')
        ->disableOriginalConstructor()
        ->getMock();

        $response = $this->getMockBuilder('Zend\Http\Response')
        ->disableOriginalConstructor()
        ->getMock();

        $this->httpClient->expects($this->once())
        ->method('request')
        ->with('GET')
        ->will($this->returnValue($response));

        $this->httpClient->expects($this->once())
        ->method('setRawData')
        ->with('{"foo":"bar"}');

        $this->httpClient->expects($this->once())
        ->method('setUri')
        ->with('http://localhost:9200/foo/bar/_search');

        $this->queryMapper->expects($this->once())
        ->method('map')
        ->with($query)
        ->will($this->returnValue(array('foo' => 'bar')));

        $this->client->search($this->metadata, $query);
    }

    /**
     * @test
     * @cover ElasticSearchClient::addToIndex
     * @cover ElasticSearchClient::bulk
     */
    public function testAddToIndex()
    {
        $objects = array();
        $objects[0] = new \stdClass();
        $objects[0]->foo = "bar";

        $this->indexMapper
        ->expects($this->once())
        ->method('add')
        ->with($this->metadata, $objects)
        ->will($this->returnValue(array(array('foo' => 'bar'), array('bar' => 'foo'))));

        $this->httpClient->expects($this->once())
        ->method('setRawData')
        ->with('{"foo":"bar"}'."\n".'{"bar":"foo"}'."\n");

        $this->httpClient->expects($this->once())
        ->method('request')
        ->with('PUT');

        $this->client->addToIndex($this->metadata, $objects);
    }
}