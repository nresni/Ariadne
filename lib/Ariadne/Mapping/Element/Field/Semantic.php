<?php
namespace Ariadne\Mapping\Element\Field;

use Ariadne\Mapping\Element\Field;

/**
 * Semantic field type
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
abstract class Semantic extends Field
{
    /**
     * Set to analyzed for the field to be indexed and searchable after being broken down into token using an analyzer. not_analyzed means that its still searchable, but does not go through any analysis process or broken down into tokens. no means that it won’t be searchable at all. Defaults to analyzed.
     *
     * @var string
     */
    protected $index = 'no';

    /**
     * Set to yes the store actual field in the index, no to not store it. Defaults to no (note, the JSON document itself is stored, and it can be retrieved from it).
     *
     * @var string
     * @validation:Choice({"yes", "no"})
     */
    public $store = 'no';

    /**
     * The boost value. Defaults to 1.0.
     *
     * @var float
     */
    protected $boost = 1.0;

    /**
     * When there is a (JSON) null value for the field, use the null_value as the field value. Defaults to not adding the field at all.
     *
     * @var ?
     */
    protected $nullValue;

    /**
     * Should the field be included in the _all field (if enabled). Defaults to true or to the parent object type setting.
     *
     * @var boolean
     */
    protected $includeInAll = true;

    /**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param unknown_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return the $store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param string $store
     */
    public function setStore($store)
    {
        $this->store = $store;
    }

    /**
     * @return the $index
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return the $boost
     */
    public function getBoost()
    {
        return $this->boost;
    }

    /**
     * @param float $boost
     */
    public function setBoost($boost)
    {
        $this->boost = $boost;
    }

    /**
     * @return the $nullValue
     */
    public function getNullValue()
    {
        return $this->nullValue;
    }

    /**
     * @param ? $nullValue
     */
    public function setNullValue($nullValue)
    {
        $this->nullValue = $nullValue;
    }

    /**
     * @return the $includeInAll
     */
    public function getIncludeInAll()
    {
        return $this->includeInAll;
    }

    /**
     * @param boolean $includeInAll
     */
    public function setIncludeInAll($includeInAll)
    {
        $this->includeInAll = $includeInAll;
    }
}