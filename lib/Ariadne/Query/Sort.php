<?php
namespace Ariadne\Query;

/**
 * A sort definition
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class Sort implements \IteratorAggregate
{
    /**
     * @var unknown_type
     */
    const ASC = 'asc';

    /**
     * @var unknown_type
     */
    const DESC = 'desc';

    /**
     * @var array direction
     */
    protected $sorts = array();

    /**
     * Add a field to the sort list
     *
     * @param string field
     * @param integer direction
     */
    public function addField($field, $direction = self::ASC)
    {
        $this->sorts[] = array($field => $direction);

        return $this;
    }

    /**
     * Add the special field score to the sort list
     *
     * @param integer direction
     */
    public function addScore($direction = self::DESC)
    {
        $this->sorts[] = array('_score' =>  $direction);

        return $this;
    }

    /**
     * @return ArrayIterator iterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->sorts);
    }
}