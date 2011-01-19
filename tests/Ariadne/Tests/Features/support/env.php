<?php
require realpath(__DIR__.'/../../../../bootstrap.php');

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

// doctrine
use Doctrine\Common\Annotations\AnnotationReader;

// doctrine-mongodb-odm
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;


// symfony component
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader as ValidatorAnnotationLoader;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory as ValidatorClassMetadataFactory;
use Symfony\Component\Console\Input\ArrayInput;

// Zend
use Zend\Http\Client;

// elastic search client
use Ariadne\Engine\ElasticSearch\ResponseMapper;
use Ariadne\Engine\ElasticSearch\QueryMapper;
use Ariadne\Engine\ElasticSearch\IndexMapper;
use Ariadne\Engine\ElasticSearch;

// mapping
use Ariadne\Mapping\Loader\AnnotationLoader;
use Ariadne\Mapping\ClassMetadataFactory;
use Ariadne\SearchManager;


$world->httpClient = new Client();

//$world->httpClient->setAdapter('Ariadne\Http\Client\Adapter\Test');

//$world->httpClient->getAdapter()->setFixturesBasePath(realpath(__DIR__ . '/../../Fixture/Api'));

$loader = new ValidatorAnnotationLoader();

$metadataFactory = new ValidatorClassMetadataFactory($loader);

$validatorFactory = new ConstraintValidatorFactory();

$validator = new Validator($metadataFactory, $validatorFactory);

$reader = new AnnotationReader();

$loader = new AnnotationLoader($reader, $validator);

$mapping = new ClassMetadataFactory($loader);

$indexMapper = new IndexMapper();

$queryMapper = new QueryMapper();

$responseMapper = new ResponseMapper();

$engine = new ElasticSearch($world->httpClient, $indexMapper, $queryMapper, $responseMapper);

$world->searchManager = new SearchManager($mapping, $engine);





