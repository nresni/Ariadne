<?php
namespace Ariadne\Tests\Functional\SearchManager;

use Ariadne\Tests\Functional\BaseTest;
use Ariadne\Tests\Fixture\Model\Article;
use Ariadne\Tests\Fixture\Model\Author;
use Ariadne\Response\Result\Hit;
use Ariadne\Response\Result;
use Ariadne\Query\QueryString;

/**
 * Enter description here ...
 * @author dstendardi
 */

class SearchTest extends BaseTest
{
    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        if ($this->shouldDump()) {

            $this->getHttpClient()->getAdapter()->setNextResponseFromFile(false);

            $object = new Article();
            $object->setId(1);
            $object->setTitle("Chuck");
            $object->setRate(2.5);
            $object->setDate(new \DateTime('2009-08-10'));

            $author = new Author();
            $author->setName('Norris');

            $object->setAuthor($author);

            $this->getSearchManager()->addToIndex($object);
            $this->getSearchManager()->flush();

            sleep(1);
        }
    }

    /**
     *
     * Enter description here ...
     */
    public function testSearch()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/search/response/nominal.txt');

        $query = $this->getSearchManager()->createQuery('Ariadne\Tests\Fixture\Model\Article');

        $query->setQueryString(new QueryString("Chuck AND author.name:Norris", "title"));

        $this->assertEquals($this->getNominalResult(), $query->getResults());

        $this->getHttpTester()->compare('elasticsearch/search/request/nominal.txt');
    }

    /**
     * Retuns the nominal expected response
     */
    protected function getNominalResult()
    {
        $expected = new Result();

        $hit = new Hit();
        $hit->title = "Chuck";
        $hit->rate = 2.5;
        $hit->date = '2009-08-10';

        $hit->author = new \stdClass();
        $hit->author->name = 'Norris';

        $expected->getHits()->add($hit);

        return $expected;
    }

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function tearDown()
    {
        if ($this->shouldDump()) {

            $this->httpClient->getAdapter()->setNextResponseFromFile(false);

            $object = new Article();
            $object->setId(1);

            $this->getSearchManager()->removeFromIndex($object);
            $this->getSearchManager()->flush();
        }
    }

}