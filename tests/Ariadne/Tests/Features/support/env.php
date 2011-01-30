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
use Doctrine\ODM\MongoDB\Mapping\Adapter\AnnotationDriver;


// symfony component
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader as ValidatorAnnotationLoader;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory as ValidatorClassMetadataFactory;
use Symfony\Component\Console\Input\ArrayInput;

// Zend
use Zend\Http\Client;

// elastic search client
use Ariadne\Client\ElasticSearchClient;
use Ariadne\Adapter\ElasticSearchAdapter;

// mapping
use Ariadne\Mapping\Loader\AnnotationLoader;
use Ariadne\Mapping\ClassMetadataFactory;
use Ariadne\SearchManager;


$world->httpClient = new Client();

$loader = new ValidatorAnnotationLoader();

$metadataFactory = new ValidatorClassMetadataFactory($loader);

$validatorFactory = new ConstraintValidatorFactory();

$validator = new Validator($metadataFactory, $validatorFactory);

$reader = new AnnotationReader();

$loader = new AnnotationLoader($reader, $validator);

$mapping = new ClassMetadataFactory($loader);

$client = new ElasticSearchClient($world->httpClient);

$driver = new ElasticSearchAdapter($client);

$world->searchManager = new SearchManager($mapping, $driver);





