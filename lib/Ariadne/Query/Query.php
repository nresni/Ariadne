<?php
namespace Ariadne\Query;

use Doctrine\Common\Collections\ArrayCollection;

use Ariadne\SearchManager;
use Ariadne\Query\TermCollection;
use Ariadne\Query\FacetCollection;

/**
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class Query
{
    /**
     * @var integer
     */
    const OPERATOR_AND = 1;

    /**
     * @var integer
     */
    const OPERATOR_OR = 2;

    /**
     * @var QueryString
     */
    protected $queryString;

    /**
     * @var Manager $manager
     */
    protected $manager;

    /**
     * @var string class name
     */
    protected $className;

    /**
     * @var integer start
     */
    protected $start = 0;

    /**
     * @var integer size
     */
    protected $size = 20;

    /**
     * Initialize related collections
     */
    public function __construct(SearchManager $manager, $className)
    {
        $this->setClassName($className);

        $this->manager = $manager;
    }

    /**
     * @param integer size
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return integer size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return integer from
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param integer from
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return mixed results
     */
    public function getResults()
    {
        return $this->manager->search($this);
    }

    /**
     * @return the $queryStrings
     */
    public function getQueryString()
    {
        if (null === $this->queryString) {
            $this->queryString = new QueryString();
        }

        return $this->queryString;
    }

    /**
     * @param ArrayCollection $queryStrings
     */
    public function setQueryString(QueryString $queryString)
    {
        $this->queryString = $queryString;

        return $this;
    }

    /**
     * @return the $className
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

}