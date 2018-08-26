<?php

require "vendor/autoload.php";

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class FeatureContext extends BrowserStackContext
{
    /**
     * @Given I am on the login page
     */
    public function iAmOnTheLoginPage()
    {
        $this->getSession()->visit('http://tss-test-site.s3-website-ap-southeast-2.amazonaws.com/signin');
    }

    /**
     * @When I fill in :arg1 with :arg2
     */
    public function iFillInWith($arg1, $arg2)
    {
        $this->getSession()->getPage()->fillField($arg1, $arg2);
    }

    /**
     * @When I press :arg1
     */
    public function iPress($arg1)
    {
        $this->getSession()->getPage()
            ->find('xpath', '//*[@id="app"]/div/div/div/div/div/form/div[3]/div/button[2]')
            ->submit();
    }

    /**
     * @Then I should be on the users home page
     */
    public function iShouldBeOnTheUsersHomePage()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see :arg1
     */
    public function iShouldSee($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I click the :arg1 link
     */
    public function iClickTheLink($arg1)
    {
        $link = $this->getSession()->getPage()->find('xpath', '//a[text()="'.$arg1.'"]');
        $link->click();
    }

    /**
     * @When I press the :arg1 button
     */
    public function iPressTheButton($arg1)
    {
        $button = $this->getSession()->getPage()->find('xpath', '//button[text()="'.$arg1.'"]');
        $button->press();
    }

    /**
     * @Then I should be on the forgot password page
     */
    public function iShouldBeOnTheForgotPasswordPage()
    {

    }

    /**
     * @Given wait :arg1
     */
    public function wait($arg1)
    {
        $this->getSession()->wait($arg1);
    }

    

    /**
     * @Then I should see a modal appear
     */
    public function iShouldSeeAModalAppear()
    {
        throw new PendingException();
    }
}
