<?php
namespace Ariadne\Mapping;

use Ariadne\Mapping\ClassMetadata;
use Ariadne\Mapping\Element\Facet;
use Ariadne\Mapping\Element\Embed;
use Ariadne\Mapping\Element\Index;
use Ariadne\Mapping\Element\Field;

/**
 * Class metadata contains the mapping configuration
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class ClassMetadata
{
    /**
     * @var ReflectionClass
     */
    protected $reflClass;

    /**
     * The class name
     *
     * @var string the index name
     */
    protected $className;

    /**
     * @var Index
     */
    protected $index;

    /**
     * @var array members
     */
    protected $fields = array();

    /**
     * @var array $embedded
     */
    protected $embeds = array();

    /**
     *
     * Enter description here ...
     * @var unknown_type
     */
    protected $embeddedsMetadata = array();

    /**
     * Constructs a metadata for the given class
     *
     * @param string $class
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the properties to be serialized
     *
     * @return array
     */
    public function __sleep()
    {
        return array('className', 'fields', 'embeddedsMetadata', 'embeds');
    }

    /**
     * @return the $index
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param Index $index
     */
    public function setIndex(Index $index)
    {
        $this->index = $index;
    }

    /**
     * Returns the fully qualified name of the class
     *
     * @return string  The fully qualified class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Adds a field to the index
     *
     * @param Field the field to add
     * @return ClassMetadata This object
     */
    public function addField($name, Field $field)
    {
        if (! isset($this->fields[$name])) {

            if (! $field->getIndexName()) {
                $field->setIndexName($name);
            }

            $this->fields[$name] = $field;
        }

        return $this;
    }

    /**
     * Add a Facet to the metadata
     *
     * @param string name
     * @param Facet $facet
     */
    public function addFacet($name, Facet $facet)
    {
        if (! isset($this->facets[$name])) {
            $this->facets[$name] = $facet;
        }

        return $this;
    }

    /**
     * Add Embed
     *
     * @param string $name
     * @param Embed $embed
     */
    public function addEmbed($name, Embed $embed)
    {
        $this->embeds[$name] = $embed;
    }

    /**
     * Returns the embeds
     *
     * @return array $embed
     */
    public function getEmbeds()
    {
        return $this->embeds;
    }

    /**
     * Sets the embedded metadata
     *
     * @param string $name
     * @param ClassMetadata $metadata
     */
    public function setEmbeddedMetadata($name, ClassMetadata $metadata)
    {
        $this->embeddedsMetadata[$name] = $metadata;
    }

    /**
     * Get the embedded metadata by name
     *
     * @param string $name
     * @return ClassMetadata $metadata
     */
    public function getEmbeddedMetadata($name)
    {
        return $this->embeddedsMetadata[$name];
    }

    /**
     * Get a field metadata
     *
     * @param string $name
     * @return ClassMetadata
     */
    public function getFieldMetadata($name)
    {
        return $this->fields[$name];
    }

    /**
     * Get a facet methadata
     *
     * @param string $name
     * @return ClassMetadata
     */
    public function getFacetMetadata($name)
    {
        return $this->facets[$name];
    }

    /**
     * Returns a ReflectionClass instance for this class.
     *
     * @return ReflectionClass
     */
    public function getReflectionClass()
    {
        if (! $this->reflClass) {
            $this->reflClass = new \ReflectionClass($this->getClassName());
        }

        return $this->reflClass;
    }

    /**
     * @return the $fields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

}