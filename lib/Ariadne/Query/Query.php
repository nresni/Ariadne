<?php
namespace Ariadne\Query;

use Ariadne\SearchManager;
use Ariadne\Query\Sort;

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
     * @var Sort sort
     */
    protected $sort;

    /**
     * Initialize related collections
     */
    public function __construct(SearchManager $manager, $className)
    {
        $this->setClassName($className);

        $this->manager = $manager;

        $this->sort = new Sort();
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
     * @return boolean has query string
     */
    public function hasQueryString()
    {
        return null !== $this->queryString;
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

    /**
     * Retunrs a list of sort definitions
     *
     * @return Sort sorts
     */
    public function getSort()
    {
        return $this->sort;
    }
}