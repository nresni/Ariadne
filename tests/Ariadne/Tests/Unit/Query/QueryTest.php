<?php
namespace Ariadne\Tests\Unit\DependencyInjection;

use Ariadne\Query\QueryString;

use Ariadne\Query\Query;

/**
 * Query tests
 *
 * @author dstendardi
 */

class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Creates the query instance
     */
    protected function setUp()
    {
        $manager = $this->getMockBuilder('Ariadne\SearchManager')
          ->disableOriginalConstructor()
          ->getMock();

        $this->query = new Query($manager, 'foo');
    }

    /**
     * @test
     * @cover Query::setLimit
     * @cover Query::getLimit
     */
    public function testSetLimit()
    {
        $this->assertSame($this->query, $this->query->setLimit(10));

        $this->assertEquals(10, $this->query->getLimit());
    }

    /**
     * @test
     * @cover Query::setOffset
     * @cover Query::getOffset
     */
    public function testSetOffset()
    {
        $this->assertSame($this->query, $this->query->setOffset(10));

        $this->assertEquals(10, $this->query->getOffset());
    }

    /**
     * @test
     * @cover Query::getQueryString
     * @cover Query::setQueryString
     */
    public function testGetQueryString()
    {
        $this->assertEquals(new QueryString(), $this->query->getQueryString());

        $queryString = new QueryString();

        $queryString->setDefaultField('foo');

        $this->query->setQueryString($queryString);

        $this->assertEquals($queryString, $this->query->getQueryString());
    }
}