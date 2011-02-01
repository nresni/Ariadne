## About

The purpose of this library is to provide a unique clean api that allow you to switch search engine transparently.

The target api should look something like this :

    <?php
    /**
     *@search:Index(name="article", idProperty="id", numberOfShards=1, numberOfReplicas=1)
     */
    class Article
    {
     /** 
      *  @search:Field\String(type="float", index="analyzed", boost="2.5", store="yes")
      */
      public $title
     
     /**
      * @search:Facet\Term()
      * @search:Field\String(store="yes", index="not_analyzed")
      */
      public $categories = array();
    }

    $query = $manager->createQuery('Article');
    $query->getQueryString()->setQuery('something');
    $query->setLimit(10)->setOffset(5);
   
    $results = $query->getResults()

   ?>

## Status

Work in progress, this library is not functional yet.

## Planned Implementations

#### Elastic Search
Elastic search is a very promising distributed search system based on lucene. 

#### Solr
Solr is an Apache project, stable and robust.

#### Zend_Lucene (standalone)
a full php implementation of lucene.