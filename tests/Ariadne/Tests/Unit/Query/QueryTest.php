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
     * @cover Query::setSize
     * @cover Query::getSize
     */
    public function testSetSize()
    {
        $this->assertSame($this->query, $this->query->setSize(10));

        $this->assertEquals(10, $this->query->getSize());
    }

    /**
     * @test
     * @cover Query::setStart
     * @cover Query::getStart
     */
    public function testSetStart()
    {
        $this->assertSame($this->query, $this->query->setStart(10));

        $this->assertEquals(10, $this->query->getStart());
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