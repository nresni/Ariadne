<?php
namespace Ariadne\Driver\ZendLucene\Command;

use Ariadne\Driver\Command;

use Zend\Search\Lucene\Lucene;

use Zend\Search\Lucene\Document\Field;
use Zend\Search\Lucene\Document;
use Ariadne\Mapping\ClassMetadata;

/**
 * Index mapper implementation for ElasticSearch
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class AddToIndex extends Command
{
    /**
     * Transforms given objects into a bulk add operation directive
     *
     * @param ClassMetadata $metadata
     * @param array $objects
     * @param array bulk commands
     */
    public function run(ClassMetadata $metadata, array $objects)
    {
        $index = $metadata->getIndex()->getName();

        $index = Lucene::open("/tmp/index_$index");

        foreach ($objects as $object) {
            $document = $this->exportObject($metadata, $object);
            $index->addDocument($document);
        }
    }

    /**
     * Export an object recursivly, using associated metadata
     *
     * @param ClassMetadata $metadata
     * @param stdClass $object
     * @return array object
     */
    protected function exportObject(ClassMetadata $metadata, $object)
    {
        $document = new Document();

        foreach ($metadata->getFields() as $property => $field) {

            $getter = 'get' . self::camelize($property);

            $value = $object->$getter();

            if ($value && 'date' === $field->getType()) {
                $value = $value->format($field->getFormat());
            }

            $type = $field->getType();

            $encoding = mb_detect_encoding($value);

            $isStored = $field->getStore() === 'yes';

            $isIndexed = $field->getIndex() != "no";

            $isTokenized = $field->getIndex() == "analyzed";

            $field = new Field($field->getIndexName(), $value, $encoding, $isStored, $isIndexed, $isTokenized);

            $document->addField($field);

            $doc[$property] = $value;
        }

        $document->addField(Field::unIndexed('_doc', json_encode($doc)));

        return $document;
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