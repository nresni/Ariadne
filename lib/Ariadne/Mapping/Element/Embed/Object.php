<?php
namespace Ariadne\Mapping\Element\Embed;

use Ariadne\Mapping\Element\Embed;

use Ariadne\Mapping\Element;

/**
 * Enter description here ...
 * @author dstendardi
 */

class Object extends Embed
{
    /**
     * Should be included or not ?
     *
     * @var boolean
     */
    protected $enabled = true;

    /**
     * Path
     * .
     * @var string path
     */
    protected $path;

    /**
     * dynamic
     *
     * @var boolean dynamic
     */
    protected $dynamic;

    /**
     * @return the $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return the $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return the $dynamic
     */
    public function getDynamic()
    {
        return $this->dynamic;
    }

    /**
     * @param boolean $dynamic
     */
    public function setDynamic($dynamic)
    {
        $this->dynamic = $dynamic;
    }

}