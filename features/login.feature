Feature: Login TSS
    As a user I want to log into the TSS solution
    
    Scenario: Login TSS
        Given I am on the login page
        When I fill in "email" with "jerome.erasmus@4mation.com.au"
        And I fill in "password" with "R@bbit99"
        And wait "1000"
