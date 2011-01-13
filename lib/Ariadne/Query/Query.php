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
    protected $offset = 0;

    /**
     * @var integer size
     */
    protected $limit = 20;

    /**
     * Initialize related collections
     */
    public function __construct(SearchManager $manager, $className)
    {
        $this->setClassName($className);

        $this->manager = $manager;
    }

    /**
     * @param integer $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return integer $limit
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return integer $offset
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param integer $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

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