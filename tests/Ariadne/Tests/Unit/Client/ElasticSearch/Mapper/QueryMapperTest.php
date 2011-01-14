<?php
namespace Ariadne\Tests\Unit\Client\ElasticSearch\Mapper;

use Ariadne\Query\Sort;

use Ariadne\Query\Query;

use Ariadne\Client\ElasticSearch\ElasticSearchClient;
use Ariadne\Client\ElasticSearch\Mapper\QueryMapper;

/**
 * Exposer for the get file name method
 *
 * @author dstendardi
 */

class QueryMapperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->mapper = new QueryMapper();
    }

    /**
     * @test
     * @cover QueryMapper::map
     */
    public function testMap()
    {
        $query = $this->getMockBuilder('Ariadne\Query\Query')
        ->disableOriginalConstructor()
        ->setMethods(array('getSort'))
        ->getMock();

        $sort = new Sort();

        $sort->addField('foo')->addScore();

        $query->expects($this->once())
        ->method('getSort')
        ->will($this->returnValue($sort));

        $sorts = array('from' => 0, 'size' => 20, 'sort' => array(array('foo' => 'asc'), array('_score' => 'desc')));

        $this->assertEquals($sorts, $this->mapper->map($query));
    }
}