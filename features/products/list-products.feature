Feature:
    In order to browse our Products
    As a user
    I want to request a list of Products

    Scenario: I request a list of Products
        When I make a request for products
        Then I should receive a list of products ordered by most expensive monthly cost first
