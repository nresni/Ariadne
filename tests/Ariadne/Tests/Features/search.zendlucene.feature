Feature: Search 
  In order to find documents
  As an Ariadne user
  I want to use the ariadne search manager

  Background:
    Given My search backend is ZendLucene
      And The "Ariadne\Tests\Fixture\Model\Article" index
      | id | title       | rate | date       |
      | 1  | chuck       | 2.5  | 2009-10-12 |
      | 2  | steven      | 1.5  | 2005-09-13 |
      | 3  | silvester   | 3.4  | 2004-05-20 |
      | 4  | arnold      | 2.4  | 2003-09-04 |
      | 5  | jean claude | 1.4  | 2005-09-10 |

  Scenario: Simple keyword search
    Given A new query for "Ariadne\Tests\Fixture\Model\Article"
      And The query string is "chuck"
      And The query default field is "title"
      And The query default operator is "and"
     When I run the query
     Then I should have the following result
       | title       |
       | chuck       |