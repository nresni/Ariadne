<?php
namespace Ariadne\Engine\ElasticSearch\Mapper;

use Ariadne\Mapping\ClassMetadata;

/**
 * Index mapper implementation for ElasticSearch
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class IndexMapper
{
    /**
     * Transforms given objects into a bulk add operation directive
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @param array bulk commands
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
     * Transforms given objects into a bulk delete operation
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @return array bulk commands
     */
    public function remove(ClassMetadata $metadata, array $objects)
    {
        $index = $metadata->getIndex();

        $idGetter = 'get' . self::camelize($index->getIdProperty());
        $map = array();
        foreach ($objects as $object) {
            $map[] = array('delete' => array('_index' => $index->getName(), '_type' => $metadata->getClassName(), '_id' => $object->$idGetter()));
        }

        return $map;
    }

    /**
     * Export an object recursivly, using associated metadata
     *
     * @param ClassMetadata $metadata
     * @param stdClass $object
     * @return array object
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
     * @todo remove this
     * @param string $input
     */
    public static function camelize($input)
    {
        return preg_replace(array('/(?:^|_)+(.)/e', '/\.(.)/e'), array("strtoupper('\\1')", "'_'.strtoupper('\\1')"), $input);
    }
}