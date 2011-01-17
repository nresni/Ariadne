<?php
use Ariadne\Tests\Fixture\Model\Article;
use Ariadne\Tests\Fixture\Model\Author;

$steps->Given('/^The "([^"]+)" index$/', function($world, $class, $table) {

    //$world->httpClient->getAdapter()->setNextResponseFromFile(false);

    $world->searchManager->dropIndex($class);

    $world->searchManager->createIndex($class);

    foreach($table->getHash() as $row)
    {
        $object = new Article();

        $object->setId($row['id']);

        $object->setTitle($row['title']);

        $object->setRate($row['rate']);

        $object->setDate(new \DateTime($row['date']));

        $world->searchManager->addToIndex($object);
    }

    $world->searchManager->flush();

    sleep(1);
});