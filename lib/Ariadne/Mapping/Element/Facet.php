<?php
namespace Ariadne\Mapping\Element;

use Ariadne\Mapping\Element;


abstract class Facet extends Element
{
    /**
     * @var string name
     */
    protected $name;


    /**
     * @return string the name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string the name
     */
    public function setName($name)
    {
        return $this->name = $name;
    }
}