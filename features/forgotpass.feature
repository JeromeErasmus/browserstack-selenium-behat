Feature: Password Reset and Recovery
    As a user I want to retrieve my lost password
    
    Scenario: Reset Password
        Given I am on the login page
        And wait "1000"
        When I press the "Forgot password" button
        Then I should see a modal appear
        And wait "1000"
