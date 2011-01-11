<?php
namespace Ariadne\Response;

use Ariadne\Response\Result\HitCollection;

class Result
{
    protected $hits;

    protected $metas;

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
     * @param field_type $hits
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    }
}