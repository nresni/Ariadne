<?php
namespace Ariadne\Driver;

use Zend\Search\Lucene\Lucene;

use Ariadne\Query\Query;
use Ariadne\Mapping\ClassMetadata;

/**
 * Elastic Search Client
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ZendLuceneDriver extends Driver
{
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
            'SearchIndex'     => 'Ariadne\Driver\ZendLucene\Command\SearchIndex',
            'AddToIndex'      => 'Ariadne\Driver\ZendLucene\Command\AddToIndex',
            'RemoveFromIndex' => 'Ariadne\Driver\ZendLucene\Command\RemoveFromIndex',
            'CreateIndex'     => 'Ariadne\Driver\ZendLucene\Command\CreateIndex',
            'DropIndex'       => 'Ariadne\Driver\ZendLucene\Command\DropIndex'
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