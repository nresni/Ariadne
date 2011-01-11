<?php
namespace Ariadne\Tests\Fixture\Model;
/**
 * A test entity
 */
class Author
{
    /**
     * @var int
     */
    public $id;

    /**
     * @search:Field\String(index="analyzed", store="yes", boost="2")
     */
    public $name;

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}