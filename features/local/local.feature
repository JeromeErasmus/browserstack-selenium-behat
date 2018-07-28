Feature: BrowserStack Local Testing
    
Scenario: Can check tunnel working
    Given I am on "http://bs-local.com:45691/check"
    Then I should see "Up and running"
