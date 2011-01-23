<?php
use Ariadne\Driver\ZendLuceneDriver;
use Ariadne\Client\ElasticSearchClient;
use Ariadne\Driver\ElasticSearchDriver;

$steps->Given('/^My search backend is ElasticSearch$/', function($world) {

    $client = new ElasticSearchClient($world->httpClient);

    $driver = new ElasticSearchDriver($client);

    $world->searchManager->setDriver($driver);
});


$steps->Given('/^My search backend is ZendLucene$/', function($world) {

    $driver = new ZendLuceneDriver();

    $world->searchManager->setDriver($driver);
});
