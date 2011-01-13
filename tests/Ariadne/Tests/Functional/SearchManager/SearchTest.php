<?php
namespace Ariadne\Tests\Functional\SearchManager;

use Ariadne\Tests\Functional\BaseTest;
use Ariadne\Tests\Fixture\Model\Article;
use Ariadne\Tests\Fixture\Model\Author;
use Ariadne\Response\Result\Hit;
use Ariadne\Response\Result;
use Ariadne\Query\Query;

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
     * @test
     */
    public function testSearch()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/search/response/nominal.txt');

        $query = $this->getSearchManager()->createQuery('Ariadne\Tests\Fixture\Model\Article');

        $query->getQueryString()->setQuery("Chuck AND author.name:Norris")->setDefaultField("title")->setDefaultOperator(Query::OPERATOR_OR);

        $query->setOffset(0)->setLimit(10);

        $this->assertEquals($this->getNominalResult(), $query->getResults());

        $this->getHttpTester()->compare('elasticsearch/search/request/nominal.txt');
    }

    /**
     * Retuns the nominal expected response
     */
    protected function getNominalResult()
    {
        $expected = new Result();

        $doc = new \stdClass();
        $doc->title = "Chuck";
        $doc->rate = 2.5;
        $doc->date = '2009-08-10';

        $doc->author = new \stdClass();
        $doc->author->name = 'Norris';

        $hit = new Hit();

        $hit->setDocument($doc);

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