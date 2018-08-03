<?php

require 'vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;
use Behat\Behat\Event\FeatureEvent;
use Behat\Behat\Event\ScenarioEvent;

class BrowserStackContext extends Behat\Behat\Context\BehatContext
{
    protected $CONFIG;
    protected static $driver;
    private static $bs_local;
    private static $dotenv;

    public function __construct($parameters){
        self::$dotenv = new Dotenv();
        self::$dotenv->load(dirname(__FILE__). getenv('ENV_FILE'));
        
        $GLOBALS['CONFIG'] = $parameters["browserstack"];
        $GLOBALS['BROWSERSTACK_USERNAME'] = getenv('BROWSERSTACK_USERNAME');
        $GLOBALS['BROWSERSTACK_ACCESS_KEY'] = getenv('BROWSERSTACK_ACCESS_KEY');
    }

    /** @BeforeFeature */
    public static function setup(FeatureEvent $scope)
    {
        $CONFIG = $GLOBALS['CONFIG'];
        $task_id = getenv('TASK_ID') ? getenv('TASK_ID') : 0;
        
        $url = "https://" . $GLOBALS['BROWSERSTACK_USERNAME'] . ":" . $GLOBALS['BROWSERSTACK_ACCESS_KEY'] . "@" . $CONFIG['server'] ."/wd/hub";
        $caps = $CONFIG['environments'][$task_id];
        
        foreach ($CONFIG["capabilities"] as $key => $value) {
            if(!array_key_exists($key, $caps))
            $caps[$key] = $value;
        }
        
        $caps['browserstack.debug'] = true;
        $caps['browserstack.console'] = 'errors';
        $caps['browserstack.networkLogs'] = true;
        
        if(array_key_exists("browserstack.local", $caps) && $caps["browserstack.local"])
        {
            $bs_local_args = array("key" => $GLOBALS['BROWSERSTACK_ACCESS_KEY']);
            self::$bs_local = new BrowserStack\Local();
            self::$bs_local->start($bs_local_args);
        }
        
        self::$driver = RemoteWebDriver::create($url, $caps);
        var_dump(self::$driver->getSessionID());
    }

    

    /** @AfterFeature */
    public static function tearDown()
    {
        self::$driver->quit();
        if(self::$bs_local) self::$bs_local->stop();
    }

    /** @BeforeScenario */
    public static function beforeScrenario(ScenarioEvent $scope)
    {
        // var_dump($scope->getContext());die();
    }

    /** @AfterScenario */
    public static function afterScrenario(ScenarioEvent $scope)
    {
        // var_dump($scope->getScenario());die();
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
