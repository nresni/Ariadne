<?php
namespace Ariadne\Mapping;

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
     *
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

    public function addEmbed($name, Embed $embed)
    {
        $this->embeds[$name] = $embed;
    }

    public function getEmbeds()
    {
        return $this->embeds;
    }

    public function setEmbeddedMetadata($name, ClassMetadata $metadata)
    {
        $this->embeddedsMetadata[$name] = $metadata;
    }

    public function getEmbeddedMetadata($name)
    {
        return $this->embeddedsMetadata[$name];
    }

    public function getFieldMetadata($name)
    {
        return $this->fields[$name];
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