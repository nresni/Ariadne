<?php
namespace Ariadne\Engine\ElasticSearch;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Mapping\Element\Embed;
use Ariadne\Mapping\Element\Field\Date;
use Ariadne\Mapping\Element\Field\Number;
use Ariadne\Mapping\Element\Field\String;
use Ariadne\Mapping\Element\Field\Semantic;

/**
 * Index mapper implementation for ElasticSearch
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class IndexMapper
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Client.IndexMapper::create()
     */
    public function create(ClassMetadata $metadata)
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

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client\Mapper.IndexMapper::add()
     */
    public function add(ClassMetadata $metadata, array $objects)
    {
        $index = $metadata->getIndex();

        $idGetter = 'get' . self::camelize($index->getIdProperty());
        $map = array();
        foreach ($objects as $object) {
            $map[] = array('index' => array('_index' => $index->getName(), '_type' => $metadata->getClassName(), '_id' => $object->$idGetter()));
            $map[] = $this->exportObject($metadata, $object);
        }

        return $map;
    }

    /**
     * Export an object recursivly, using associated metadata
     *
     * @param ClassMetadata $metadata
     * @param stdClass $object
     */
    public function exportObject(ClassMetadata $metadata, $object)
    {
        $fields = $metadata->getFields();

        $properties = array();

        foreach ($fields as $property => $field) {
            $key = $field->getIndexName();
            $getter = 'get' . self::camelize($property);
            $value = $object->$getter();
            if ($value && 'date' === $field->getType()) {
                $value = $value->format($field->getFormat());
            }
            $properties[$key] = $value;
        }

        foreach ($metadata->getEmbeds() as $property => $embed) {
            $getter = 'get' . self::camelize($property);
            $value = $object->$getter();
            if (false === empty($value)) {
                $properties[$property] = $this->exportObject($metadata->getEmbeddedMetadata($property), $value);
            }
        }

        return $properties;
    }

    /**
     * (non-PHPdoc)
     * @see Ariadne\Client\Mapper.IndexMapper::remove()
     */
    public function remove(ClassMetadata $metadata, array $objects)
    {
        $fields = $metadata->getFields();

        $index = $metadata->getIndex();

        $idGetter = 'get' . self::camelize($index->getIdProperty());

        $map = array();

        foreach ($objects as $object) {
            $map[] = array('delete' => array('_index' => $index->getName(), '_type' => $metadata->getClassName(), '_id' => $object->$idGetter()));
        }

        return $map;
    }

    /**
     * @todo remove this
     * @param string $input
     */
    public static function camelize($input)
    {
        return preg_replace(array('/(?:^|_)+(.)/e', '/\.(.)/e'), array("strtoupper('\\1')", "'_'.strtoupper('\\1')"), $input);
    }
}