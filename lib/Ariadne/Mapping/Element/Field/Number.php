<?php
namespace Ariadne\Mapping\Element\Field;

/**
 * Mapping for number type
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Number extends Semantic
{
    /**
     * @var string the field type
     * @validation:Choice({"yes", "no"})
     */
    public $index;

    /**
     * @validation:Choice({"float", "double", "integer", "long"})
     */
    protected $type;

    /**
     * Set the (sub) type of the field
     *
     * @param string type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}