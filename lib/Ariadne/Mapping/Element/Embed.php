<?php
namespace Ariadne\Mapping\Element;

use Ariadne\Mapping\Element;

class Embed extends Element
{
    /**
     * @var String class
     */
    protected $class;

    /**
     * @return the $class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param String $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

}