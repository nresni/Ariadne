<?php
namespace Ariadne\Mapping\Element\Field;

use Ariadne\Mapping\Element\Field;

/**
 * Binary field type
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Date extends Semantic
{
    /**
     * @var string date format
     * @validation:Choice({"Y-m-d", "Y-m-d H:i:s"});
     */
    protected $format = "Y-m-d H:i:s";

    /**
     * @var integer
     * @validation:AssertType("numeric")
     */
    protected $precisionStep = 4;

    /**
     * (non-PHPdoc)
     * @see Ariadne\Mapping\Element.Field::getType()
     */
    public function getType()
    {
        return 'date';
    }
    /**
     * @return the $format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
    /**
     * @return the $precisionStep
     */
    public function getPrecisionStep()
    {
        return $this->precisionStep;
    }

    /**
     * @param integer $precisionStep
     */
    public function setPrecisionStep($precisionStep)
    {
        $this->precisionStep = $precisionStep;
    }
}