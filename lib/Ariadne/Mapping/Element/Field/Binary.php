<?php
namespace Ariadne\Mapping\Element\Field;

use Ariadne\Mapping\Element\Field;

/**
 * Binary field type
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Binary extends Field
{
    /**
     * (non-PHPdoc)
     * @see Ariadne\Mapping\Element.Field::getType()
     */
    public function getType()
    {
        return 'binary';
    }
}