<?php
namespace Ariadne\Mapping;
/**
 *  Base class for metadata objects
 *
 * @author dstendardi <david.stendardi@gmail.com>
 */
class Element
{
    /**
     * @param array properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $key => $value) {

            $method = 'set'.ucfirst($key);

            $this->$method($value);
        }
    }
}