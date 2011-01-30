<?php
namespace Ariadne\Adapter\ZendLucene;

use Zend\Search\Lucene\Lucene;

use Ariadne\Adapter\Adapter;
use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ZendLuceneAdapter extends Adapter
{
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
            'SearchIndex'     => 'Ariadne\Adapter\ZendLucene\Command\SearchIndex',
            'AddToIndex'      => 'Ariadne\Adapter\ZendLucene\Command\AddToIndex',
            'RemoveFromIndex' => 'Ariadne\Adapter\ZendLucene\Command\RemoveFromIndex',
            'CreateIndex'     => 'Ariadne\Adapter\ZendLucene\Command\CreateIndex',
            'DropIndex'       => 'Ariadne\Adapter\ZendLucene\Command\DropIndex'
        );
    }

    /**
     * Set up a command
     *
     * @param unknown_type $command
     */
    public function setupCommand($command)
    {
        return $command;
    }
}