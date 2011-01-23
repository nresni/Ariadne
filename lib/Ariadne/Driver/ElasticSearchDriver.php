<?php
namespace Ariadne\Driver;

use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Engine\MapperFactory;
use Ariadne\Client\ElasticSearchClient;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ElasticSearchDriver extends Driver
{
    /**
     * search client
     *
     * @var ElasticSearchEngine $client
     */
    protected $client;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(ElasticSearchClient $client)
    {
        $this->client = $client;
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Driver.BaseDriver::getName()
     */
    public function getName()
    {
        return 'ZendLucene';
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Driver.BaseDriver::getAvailableCommands()
     */
    public function getAvailableCommands()
    {
        return array(
            'SearchIndex'     => 'Ariadne\Driver\ElasticSearch\Command\SearchIndex',
            'AddToIndex'      => 'Ariadne\Driver\ElasticSearch\Command\AddToIndex',
            'RemoveFromIndex' => 'Ariadne\Driver\ElasticSearch\Command\RemoveFromIndex',
            'CreateIndex'     => 'Ariadne\Driver\ElasticSearch\Command\CreateIndex',
            'DropIndex'       => 'Ariadne\Driver\ElasticSearch\Command\DropIndex'
        );
    }

    /**
     * Set up a command
     *
     * @param unknown_type $command
     */
    public function getClient()
    {
        return $this->client;
    }
}