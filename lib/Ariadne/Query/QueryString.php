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

        return $this;
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

        return $this;
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

        return $this;
    }
}