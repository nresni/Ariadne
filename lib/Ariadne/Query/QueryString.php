<?php
namespace Ariadne\Query;

/**
 * Creates an index deduced from the given class metadata
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class QueryString
{
    /**
     * @param string query
     */
    protected $query;

    /**
     * @param string default field
     */
    protected $defaultField;

    /**
     * @param integer default operator
     */
    protected $defaultOperator;

    /**
     * Sets the query, and optional defaults fields and operator
     *
     * @param string $query
     * @param string $defaultField
     * @param integer $defaultOperator
     */
    public function __construct($query, $defaultField = null, $defaultOperator = Query::OPERATOR_OR)
    {
        $this->setQuery($query);

        $this->setDefaultField($defaultField);

        $this->setDefaultOperator($defaultOperator);
    }

    /**
     * @return the $defaultOperator
     */
    public function getDefaultOperator()
    {
        return $this->defaultOperator;
    }

    /**
     * @param field_type $defaultOperator
     */
    public function setDefaultOperator($defaultOperator)
    {
        $this->defaultOperator = $defaultOperator;
    }

    /**
     * @return the $query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param field_type $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return the $defaultField
     */
    public function getDefaultField()
    {
        return $this->defaultField;
    }

    /**
     * @param field_type $defaultField
     */
    public function setDefaultField($defaultField)
    {
        $this->defaultField = $defaultField;
    }

}