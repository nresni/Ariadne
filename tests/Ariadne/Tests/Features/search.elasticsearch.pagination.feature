Feature: Search 
  In order to find documents
  As an Ariadne user
  I want to use the ariadne search manager

  Background:
    Given The "Ariadne\Tests\Fixture\Model\Article" index
      | id | title       | rate | date       |
      | 1  | chuck       | 2.5  | 2009-10-12 |
      | 2  | steven      | 1.5  | 2005-09-13 |
      | 3  | silvester   | 3.4  | 2004-05-20 |
      | 4  | arnold      | 2.4  | 2003-09-04 |
      | 5  | jean claude | 1.4  | 2005-09-10 |
      And My search backend is ElasticSearch

  Scenario: Paginated search
    Given A new query for "Ariadne\Tests\Fixture\Model\Article"
      And The query string is "*"
      And The query default field is "title"
      And The query default operator is "or"
      And The query is sorted by "title" "desc"
      And the query is limited to "3"
      And the query start from "0"
     When I run the query
     Then I should have the following result
       | title       |
       | steven      |
       | silvester   |
       | jean claude |
    Given the query start from "3"
     When I run the query
     Then I should have the following result
       | title       |
       | chuck       |
       | arnold      |

