<?php

use Ariadne\Query\Query;
$steps->Given('/^A new query for "([^"]*)"$/', function($world, $arg1) {
    $world->query = $world->searchManager->createQuery($arg1);
});

$steps->And('/^The query string is "([^"]*)"$/', function($world, $arg1) {
    $world->query->getQueryString()->setQuery($arg1);
});

$steps->Given('/^The query default field is "([^"]*)"$/', function($world, $arg1) {
    $world->query->getQueryString()->setDefaultField($arg1);
});

$steps->Given('/^The query default operator is "([^"]*)"$/', function($world, $arg1) {

    switch($arg1)
    {
        case 'and':
        $operator = Query::OPERATOR_AND;
        break;
        case 'or':
        $operator = Query::OPERATOR_OR;
        break;
        default;
        $operator = $arg1;
    }

    $world->query->getQueryString()->setDefaultOperator($operator);
});

$steps->Given('/^The query is sorted by "([^"]*)" "([^"]*)"$/', function($world, $arg1, $arg2) {
    $world->query->getSort()->addField($arg1, $arg2);
});

$steps->Given('/^the query is limited to "([^"]*)"$/', function($world, $arg1) {
    $world->query->setLimit($arg1);
});

$steps->Given('/^the query start from "([^"]*)"$/', function($world, $arg1) {
    $world->query->setOffset($arg1);
});

$steps->When('/^I run the query$/', function($world) {
    $world->result = $world->query->getResults();
});

$steps->Then('/^I should have the following result$/', function($world, $table) {

   $hash = $table->getHash();

   $count = count($hash);

   assertEquals($count, count($world->result->getHits()));

   foreach($world->result->getHits() as $i => $hit) {

     foreach($hash[$i] as $name => $value)
     {
        assertEquals($value, $hit->getDocument()->$name);
     };
   }
});
