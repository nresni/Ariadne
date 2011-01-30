<?php
namespace Ariadne\Adapter\ElasticSearch;

use Ariadne\Adapter\Adapter;
use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Engine\MapperFactory;
use Ariadne\Client\ElasticSearchClient;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ElasticSearchAdapter extends Adapter
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
     * @see Ariadne\Adapter.BaseAdapter::getName()
     */
    public function getName()
    {
        return 'ZendLucene';
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Adapter.BaseAdapter::getAvailableCommands()
     */
    public function getAvailableCommands()
    {
        return array(
            'SearchIndex'     => 'Ariadne\Adapter\ElasticSearch\Command\SearchIndex',
            'AddToIndex'      => 'Ariadne\Adapter\ElasticSearch\Command\AddToIndex',
            'RemoveFromIndex' => 'Ariadne\Adapter\ElasticSearch\Command\RemoveFromIndex',
            'CreateIndex'     => 'Ariadne\Adapter\ElasticSearch\Command\CreateIndex',
            'DropIndex'       => 'Ariadne\Adapter\ElasticSearch\Command\DropIndex'
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