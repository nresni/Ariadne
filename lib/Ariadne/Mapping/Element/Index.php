<?php
namespace Ariadne\Mapping\Element;

use Ariadne\Mapping\Element;

/**
 *
 * Enter description here ...
 * @author dstendardi
 *
 */
class Index extends Element
{
    /**
     * The name of the field that will be stored in the index. Defaults to the property/field name.
     *
     * @var string
     */
    protected $name;

    /**
     * @var string the id property
     */
    protected $idProperty;

    /**
     * @var integer
     */
    protected $numberOfReplicas;

    /**
     * @var integer
     */
    protected $numberOfShards;

    /**
     * @return the $numberOfReplicas
     */
    public function getNumberOfReplicas()
    {
        return $this->numberOfReplicas;
    }

    /**
     * @return the $numberOfShards
     */
    public function getNumberOfShards()
    {
        return $this->numberOfShards;
    }

    /**
     * @param integer $numberOfReplicas
     */
    public function setNumberOfReplicas($numberOfReplicas)
    {
        $this->numberOfReplicas = $numberOfReplicas;
    }

    /**
     * @param integer $numberOfShards
     */
    public function setNumberOfShards($numberOfShards)
    {
        $this->numberOfShards = $numberOfShards;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return the $idPropertyName
     */
    public function getIdProperty()
    {
        return $this->idProperty;
    }

    /**
     * @param string $idPropertyName
     */
    public function setIdProperty($idProperty)
    {
        $this->idProperty = $idProperty;
    }

}