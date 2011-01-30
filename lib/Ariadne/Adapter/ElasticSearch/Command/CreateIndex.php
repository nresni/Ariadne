<?php
namespace Ariadne\Adapter\ElasticSearch\Command;

use Ariadne\Mapping\Element\Field\Binary;
use Ariadne\Mapping\Element\Field\Number;
use Ariadne\Mapping\Element\Field\Semantic;
use Ariadne\Mapping\Element\Field\Date;
use Ariadne\Mapping\Element\Field\String;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Adapter\Command;

/**
 * Create an index with zend lucene
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class CreateIndex extends Command
{
    /**
     * Transforms given objects into a bulk add operation directive
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @param array bulk commands
     */
    public function run(ClassMetadata $metadata)
    {
        $index = $metadata->getIndex();

        $definition = $this->createSchema($metadata);

        $settings = array('number_of_shards' => $index->getNumberOfShards(), 'number_of_replicas' => $index->getNumberOfReplicas());

        $type = $metadata->getClassName();

        $mappings = array($type => array('properties' => array()));

        $mappings[$type]['properties'] = $this->exportProperties($metadata);

        return $this->driver->getClient()->createIndex($index->getName(), array('settings' => $settings, 'mappings' => $mappings));
    }

    /**
     * Transforms object metadata into a mapping definition
     *
     * @param ClassMetadata $metadata
     */
    public function createSchema(ClassMetadata $metadata)
    {
        $index = $metadata->getIndex();

        $settings = array('number_of_shards' => $index->getNumberOfShards(), 'number_of_replicas' => $index->getNumberOfReplicas());

        $type = $metadata->getClassName();
        $mappings = array($type => array('properties' => array()));
        $mappings[$type]['properties'] = $this->exportProperties($metadata);

        return array('settings' => $settings, 'mappings' => $mappings);
    }

    /**
     * Extract and map properties for the metadata
     *
     * @param ClassMetadata $metadata
     */
    protected function exportProperties(ClassMetadata $metadata)
    {
        $map = array();

        foreach ($metadata->getFields() as $name => $field) {
            $ref = new \ReflectionObject($field);
            $class = $ref->getShortName();
            $method = sprintf('exportField%s', $class);
            $map[$name] = $this->$method($field);
        }

        foreach ($metadata->getEmbeds() as $name => $embed) {
            $embedMetadata = $metadata->getEmbeddedMetadata($name);
            $map[$name]['type'] = 'object';
            $map[$name]['properties'] = $this->exportProperties($embedMetadata);
        }

        return $map;
    }

    /**
     * Export the date type field
     *
     * @param Date $field
     * @return array $definition
     */
    public function exportFieldDate(Date $field)
    {
        $definition = array();
        $definition['format'] = $field->getFormat();
        $definition['precision_step'] = $field->getPrecisionStep();

        return array_merge($this->exportFieldSemantic($field), $definition);
    }

    /**
     * Export the number type field
     *
     * @param Number $field
     * @return array $definition
     */
    public function exportFieldNumber(Number $field)
    {
        $definition = array();

        return array_merge($this->exportFieldSemantic($field), $definition);
    }

    /**
     * Export the string type field
     *
     * @param String $field
     * @return array $definition
     */
    public function exportFieldString(String $field)
    {
        $definition = array();

        return array_merge($this->exportFieldSemantic($field), $definition);
    }

    /**
     * Base export methods for Semantic fields
     *
     * @param Semantic $field
     * @return array $definition
     */
    protected function exportFieldSemantic(Semantic $field)
    {
        $definition = array();
        $definition['store'] = $field->getStore();
        $definition['type'] = $field->getType();
        $definition['index'] = $field->getIndex();
        $definition['boost'] = $field->getBoost();

        return $definition;
    }


}