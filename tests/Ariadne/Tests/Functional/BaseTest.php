<?php
namespace Ariadne\Tests\Functional;

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
use Ariadne\Client\ElasticSearch\Mapper\ResponseMapper;
use Ariadne\Client\ElasticSearch\Mapper\QueryMapper;
use Ariadne\Client\ElasticSearch\Mapper\IndexMapper;
use Ariadne\Client\ElasticSearch\ElasticSearchClient;

// mapping
use Ariadne\Mapping\Loader\AnnotationLoader;
use Ariadne\Mapping\ClassMetadataFactory;
use Ariadne\SearchManager;

/**
 * Functional  tests base class.
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The http client
     */
    protected $httpClient;

    /**
     * @var array $testers
     */
    protected $testers = array();

    /**
     * The search manager
     *
     * @var Manager
     */
    protected $searchManager;

    /**
     * The document manager
     *
     * @var Manager
     */
    protected $documentManager;

    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        if (! $this->documentManager) {

            $config = new Configuration();
            $config->setProxyDir('/tmp');
            $config->setProxyNamespace('Proxies');
            $config->setHydratorDir(__DIR__ . '/../../../../Hydrators');
            $config->setHydratorNamespace('Hydrators');
            $config->setDefaultDB('doctrine_odm_tests');

            $reader = new AnnotationReader();
            $reader->setAnnotationNamespaceAlias('Doctrine\ODM\MongoDB\Mapping\\', 'mongodb');
            $this->annotationDriver = new AnnotationDriver($reader, __DIR__ . '/Documents');
            $config->setMetadataDriverImpl($this->annotationDriver);

            $conn = new Connection(null, array(), $config);
            $this->documentManager = DocumentManager::create($conn, $config);
        }
        return $this->documentManager;
    }

    /**
     * Get the search manager with all dependencies
     *
     * @return Manager
     */
    protected function getSearchManager()
    {
        if (! $this->searchManager) {

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

            $client = new ElasticSearchClient($this->getHttpClient(), $indexMapper, $queryMapper, $responseMapper);

            $this->searchManager = new SearchManager($mapping, $client);
        }

        return $this->searchManager;
    }

    /**
     * @return string path
     */
    public function getFixtureBasePath()
    {
        return realpath(__DIR__ . '/../Fixture/Api');
    }

    /**
     * Get a file fixture content
     *
     * @param string path
     * @param string expected
     */
    public function assertLastRequestMatchesSpec($file)
    {
        $given = $this->getHttpClient()->getLastRequest();

        $expected = file_get_contents($this->getFixtureBasePath() . '/' . $file);

        $expected = trim(str_replace(array("\n", "\r"), "", $expected));

        $given = trim(str_replace(array("\n", "\r"), "", $given));

        return $this->assertStringMatchesFormat($expected, $given);
    }

    /**
     * Returns a test  http client
     *
     * @todo this will be moved in the DI configuration
     */
    public function getHttpClient()
    {
        if (! $this->httpClient) {
            $this->httpClient = new Client();
            $adapter = $this->shouldDump() ? '\Dumper' : '\Test';
            $adapter = 'Ariadne\Http\Client\Adapter' . $adapter;
            $adapter = new $adapter();
            $adapter->setFixturesBasePath($this->getFixtureBasePath());

            $this->httpClient->setAdapter($adapter);
        }

        return $this->httpClient;
    }

    /**
     *
     * Enter description here ...
     */
    public function shouldDump()
    {
        return defined('HTTP_ADAPTER') && HTTP_ADAPTER === true;
    }

    /**
     * @return HttpTester
     */
    public function getHttpTester()
    {
        if (false === isset($this->testers['http'])) {
            $this->testers['http'] = new HttpTester($this);
        }
        return $this->testers['http'];
    }

    /**
     * Create a new kernel
     *
     * @return Kernel instance
     */
    protected function boot()
    {
        $this->kernel = $this->createKernel(array('environment' => 'test'));

        $this->kernel->boot();

        return $this->kernel;
    }
}