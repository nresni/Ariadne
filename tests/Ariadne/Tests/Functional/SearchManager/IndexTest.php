<?php
namespace Ariadne\Tests\Functional\SearchManager;

use Ariadne\Tests\Fixture\Model\Article;
use Ariadne\Tests\Functional\BaseTest;

/**
 * Enter description here ...
 * @author dstendardi
 */

class IndexTest extends BaseTest
{
    /**
     * @test
     */
    public function testCreate()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/index/create/response/nominal.txt');

        $this->getSearchManager()->createIndex('Ariadne\Tests\Fixture\Model\Article');

        $this->getHttpTester()->compare('elasticsearch/index/create/request/nominal.txt');
    }

    /**
     * @test
     */
    public function testCreateWhenAlreadyExists()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/index/create/response/alreadyexists.txt');

        $this->getSearchManager()->createIndex('Ariadne\Tests\Fixture\Model\Article');

        $this->getHttpTester()->compare('elasticsearch/index/create/request/nominal.txt');
    }

    /**
     * @test
     */
    public function testDrop()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/index/drop/response/nominal.txt');

        $this->getSearchManager()->dropIndex('Ariadne\Tests\Fixture\Model\Article');

        $this->getHttpTester()->compare('elasticsearch/index/drop/request/nominal.txt');
    }

    /**
     * @test
     */
    public function testDropMissing()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/index/drop/response/missing.txt');

        $this->getSearchManager()->dropIndex('Ariadne\Tests\Fixture\Model\Article');

        $this->getHttpTester()->compare('elasticsearch/index/drop/request/nominal.txt');
    }

    /**
     * @test
     */
    public function testAddToIndex()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/index/index/response/nominal.txt');

        $object = new Article();

        $object->setId(1);

        $object->setTitle("Chuck");

        $object->setRate(2.5);

        $object->setDate(new \DateTime('2009-08-10'));

        $this->getSearchManager()->addToIndex($object);

        $this->getSearchManager()->flush();

        $this->getHttpTester()->setExpectedBodyParser(false)->compare('elasticsearch/index/index/request/nominal.txt');
    }

    /**
     * @test
     */
    public function testRemoveFromIndex()
    {
        $this->getHttpClient()->getAdapter()->setNextResponseFromFile('elasticsearch/index/delete/response/nominal.txt');

        $object = new Article();

        $object->setId(1);

        $object->setTitle("Chuck");

        $this->getSearchManager()->removeFromIndex($object);

        $this->getSearchManager()->flush();

        $this->getHttpTester()->compare('elasticsearch/index/delete/request/nominal.txt');
    }
}