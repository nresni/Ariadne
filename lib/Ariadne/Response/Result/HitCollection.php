<?php
namespace Ariadne\Response\Result;

use Doctrine\Common\Collections\ArrayCollection;

class HitCollection extends ArrayCollection
{
    protected $total;

    protected $maxScore;

    /**
     * @return the $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return the $maxScore
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param field_type $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @param field_type $maxScore
     */
    public function setMaxScore($maxScore)
    {
        $this->maxScore = $maxScore;
    }

}