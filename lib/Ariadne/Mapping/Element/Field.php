<?php
namespace Ariadne\Mapping\Element;

use Ariadne\Mapping\Element;


abstract class Field extends Element
{
    /**
     * The name of the field that will be stored in the index. Defaults to the property/field name.
     *
     * @var string
     */
    protected $indexName;

    /**
     * @return the $indexName
     */
    public function getIndexName()
    {
        return $this->indexName;
    }

    /**
     * @param string $indexName
     */
    public function setIndexName($indexName)
    {
        $this->indexName = $indexName;
    }

    /**
     * @return string the type of the field
     */
    abstract public function getType();
}