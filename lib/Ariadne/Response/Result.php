<?php
namespace Ariadne\Response;

use Ariadne\Response\Result\HitCollection;
/**
 * Reprensents a search result.
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class Result
{
    /**
     * @var HitCollection hits
     */
    protected $hits;

    /**
     * Initialize collections
     */
    public function __construct()
    {
        $this->hits = new HitCollection();
    }

    /**
     * @return HitCollection the $hits
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @param HitCollection $hits
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    }
}