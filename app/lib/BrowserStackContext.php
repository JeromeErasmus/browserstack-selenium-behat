<?php

require 'vendor/autoload.php';
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\Dotenv\Dotenv;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\Behat\Hook\Scope\AfterFeatureScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Mink\Driver\SeleniumDriver;
use Selenium\Client;
use Behat\Mink\Session;

/**
 * Defines application features from the specific context.
 */
class BrowserStackContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    protected $CONFIG;
    protected static $driver;
    private static $dotenv;

    public function __construct(array $parameters = array())
    {
        if(array_key_exists('browserstack', $parameters))
        {
            $GLOBALS['CONFIG'] = $parameters['browserstack'];
            $GLOBALS['BROWSERSTACK_USERNAME'] = 'nathandailo1';
            $GLOBALS['BROWSERSTACK_ACCESS_KEY'] = 'vBA1X4UbENrEwN4BeEB2';
        }

        
    }
    
    /**
     * @BeforeSuite
     */
    public static function prepare(BeforeSuiteScope $scope)
    {
        // var_dump($scope->getEnvironment());
        // There is a neater way to do the below with BeHat 3.
        // Much of this is dependant on the .conf setup which is not that well documented in BeHat.
        // $settings = $scope->getSuite()->getSettings();
        // if($settings['contexts'] && count($settings['contexts']))
        // {
        //     $fContext = $settings['contexts'][0];
          
        //     if($fContext && $fContext['FeatureContext'])
        //     {
        //         $GLOBALS['CONFIG'] = $fContext["FeatureContext"]['parameters'];
        //         $GLOBALS['BROWSERSTACK_USERNAME'] = 'nathandailo1';
        //         $GLOBALS['BROWSERSTACK_ACCESS_KEY'] = 'vBA1X4UbENrEwN4BeEB2';
        //         // var_dump($fContext["FeatureContext"]['parameters']);die();
        //     }
        // }
    }

    /** @BeforeFeature */
    public static function setup(BeforeFeatureScope $scope)
    {
        echo "BEFORE FEATURE!";
        
        // I am going to re-write the below. It's going to be run differently form the shell script. 

        // Manually set up a driver session if this is a browserstack runner. 
        // We want to manyally set them up as we will be wanting to exexute multiple Features in parallel for different OS in BS 
        // if($GLOBALS['CONFIG'] && $GLOBALS['CONFIG']['browserstack'])
        // {
        //     $config = $GLOBALS['CONFIG']['browserstack'];
        //     $capabilities = $GLOBALS['CONFIG']['capabilities'];
        //     $task_id = getenv('TASK_ID') ? getenv('TASK_ID') : 0;
        //     $url = "https://" . $config['username'] . ":" . $config['access_key'] . "@" . $config['server'] ."/wd/hub";

        //     // $caps['browserstack.debug'] = true;
        //     // $caps['browserstack.console'] = 'errors';
        //     // $caps['browserstack.networkLogs'] = true;

        //     self::$driver = RemoteWebDriver::create($url, $capabilities);

        //     // init sessions
        //     // $session = new \Behat\Mink\Session(self::$driver);

        //     // start sessions
        //     $session->start();
        // }

//         self::$driver = RemoteWebDriver::create("https://nathandailo1:vBA1X4UbENrEwN4BeEB2@hub-cloud.browserstack.com/wd/hub",
//   array("platform"=>"WINDOWS", "browserName"=>"firefox"));
    }

    

    /** @AfterFeature */
    public static function tearDown()
    {
        if(self::$driver) {
            self::$driver->quit();
        }
    }

    /** @AfterFeature */
    public static function afterFeature(AfterFeatureScope $scope)
    {
        
    }

    /** @BeforeScenario */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        var_dump($this->getMink());
        // get the webdriver session
        // var_dump($this->getSession()->getDriver()->getWebDriverSession());
        // var_dump($this->getSession()->getDriver()->getWebDriverSessionId());
    }

    /** @AfterScenario */
    public function afterScrenario(AfterScenarioScope $scope)
    {
        echo '----------------------------------------------------'.PHP_EOL;
        // var_dump(self::$driver->getSession());
        echo 'name : '.$scope->getName().PHP_EOL;
        // var_dump($scope->getTestResults());
        echo 'result code : '.$scope->getTestResult()->getResultCode().PHP_EOL;
        echo 'is passed : '.($scope->getTestResult()->isPassed() ? 'true' : 'false').PHP_EOL;
        
        echo '----------------------------------------------------';
    }

    
    /**
     * Gets the log files from the test once it is completed 
     *
     * @return bool 
     * @access private
     */
    private function getLogs(string $buildId, string $sessionId)
    {
        try
        {
            // curl -u "nathandailo1:vBA1X4UbENrEwN4BeEB2" https://api.browserstack.com/automate/sessions/4fd2c9a46b4b1b672c4a4a70de820736d1305be0
            // curl -u "nathandailo1:vBA1X4UbENrEwN4BeEB2" https://api.browserstack.com/automate/builds/cc6d310e0a00ded9c40a8556d65b219c8a1069d8/sessions/4fd2c9a46b4b1b672c4a4a70de820736d1305be0/logs
            $url = 'https://api.browserstack.com/automate/browsers.json';
            $response = $this->client->request('GET', $url, $this->auth);
            $contents = json_decode($response->getBody()->getContents());
            $contents = json_encode($contents, JSON_PRETTY_PRINT);
            if($contents)
            {
                $this->writeFile('capabilities.txt', $contents);
                return true;
            }
            else
            {
                return false;
            }

        }
        catch (RequestException $e)
        {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse())
            {
                echo Psr7\str($e->getResponse());
            }
            return false;
        }
    }
}
?>
