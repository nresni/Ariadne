<?php
use Ariadne\Engine\ElasticSearch\MapperFactory;
use Ariadne\Engine\ElasticSearch;

$steps->Given('/^My search backend is ElasticSearch$/', function($world) {

    $engine = new ElasticSearch($world->httpClient, new MapperFactory());

    $world->searchManager->setEngine($engine);
});
