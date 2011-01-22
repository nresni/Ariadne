<?php
use Ariadne\Client\ElasticSearchClient;
use Ariadne\Driver\ElasticSearchDriver;

$steps->Given('/^My search backend is ElasticSearch$/', function($world) {

    $client = new ElasticSearchClient($world->httpClient);

    $driver = new ElasticSearchDriver($client);

    $world->searchManager->setDriver($driver);
});
