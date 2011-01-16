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
     * @var int total
     */
    protected $total;

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
    /**
     * @return the $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

}