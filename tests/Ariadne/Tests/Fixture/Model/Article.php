<?php
namespace Ariadne\Tests\Fixture\Model;
/**
 * A test entity
 *
 * @mongodb:Document(db="my_db", collection="articles")
 * @search:Index(name="article", idProperty="id", numberOfShards=1, numberOfReplicas=1)
 */
class Article
{
    /**
     * @mongodb:Id
     */
    public $id;

    /**
     * @search:Field\String(store="yes", boost="2.5")
     */
    public $title;

    /**
     * @var float rate
     * @search:Field\Number(type="float", store="no", index="no")
     */
    public $rate;

    /**
     * @var Date
     * @search:Field\Date(format="Y-m-d", precisionStep="4")
     */
    public $date;

    /**
     * @search:Embed\Object(class="Ariadne\Tests\Fixture\Model\Author")
     */
    public $author;

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param field_type $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return float the $rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }
    /**
     * @return the $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param Date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return the $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param field_type $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
}