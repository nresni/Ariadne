<?php
use Ariadne\Adapter\ZendLuceneAdapter;
use Ariadne\Client\ElasticSearchClient;
use Ariadne\Adapter\ElasticSearchAdapter;

$steps->Given('/^My search backend is ElasticSearch$/', function($world) {

    $client = new ElasticSearchClient($world->httpClient);

    $driver = new ElasticSearchAdapter($client);

    $world->searchManager->setAdapter($driver);
});


$steps->Given('/^My search backend is ZendLucene$/', function($world) {

    $driver = new ZendLuceneAdapter();

    $world->searchManager->setAdapter($driver);
});
