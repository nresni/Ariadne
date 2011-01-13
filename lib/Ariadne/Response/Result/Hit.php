<?php
namespace Ariadne\Response\Result;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Reprensents a search Hit.
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class Hit implements \IteratorAggregate
{
    /**
     * @var integer score
     */
    protected $score;

    /**
     * @var stdClass $document
     */
    protected $document;

    /**
     * @return the $document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * (non-PHPdoc)
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
      return new \ArrayIterator($this->document);
    }

    /**
     * @param stdClass $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return integer the $score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param integer $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }
}