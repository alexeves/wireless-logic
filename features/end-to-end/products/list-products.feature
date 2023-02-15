Feature:
  In order to browse our Products
  As a user
  I want to request a list of Products

  Scenario: I successfully request a list of Products
    When I make a request for products
    Then I should receive a list of products ordered by most expensive monthly cost first

  Scenario: I unsuccessfully request a list of Products
    When I make a bad request for products
    Then I should receive an appropriate error message
