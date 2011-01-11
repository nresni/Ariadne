<?php
namespace Ariadne\Tests\Fixture\Model;
/**
 * A test entity
 */
class Category
{
    /**
     * @var int
     */
    public $id;

    /**
     * @search:Field\String(index="yes")
     */
    public $name;

}