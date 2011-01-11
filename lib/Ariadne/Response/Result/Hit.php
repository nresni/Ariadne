<?php
namespace Ariadne\Response\Result;

use Doctrine\Common\Collections\ArrayCollection;

class Hit
{
    protected $score;

    protected $document;
    /**
     * @return the $document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param field_type $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }
    /**
     * @return the $score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param field_type $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

}