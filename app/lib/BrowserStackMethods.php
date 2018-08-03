<?php
declare(strict_types=1);
require 'vendor/autoload.php';

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Methods for additional Browserstack operations
 *
 * @package    
 */
class BrowserStackMethods
{
    private static $dotenv;
    private $auth;
    private $client;

    /**
     * Class constructor
     *
     * @param string $arg1  the string to quote
     * @access public
     */
    public function __construct(string $method = null)
    {
        self::$dotenv = new Dotenv();
        self::$dotenv->load(dirname(__FILE__) . getenv('ENV_FILE'));

        $GLOBALS['BROWSERSTACK_USERNAME'] = getenv('BROWSERSTACK_USERNAME');
        $GLOBALS['BROWSERSTACK_ACCESS_KEY'] = getenv('BROWSERSTACK_ACCESS_KEY');

        $this->client = new Client();
        $this->auth = [
            'auth' => [
                $GLOBALS['BROWSERSTACK_USERNAME'],
                $GLOBALS['BROWSERSTACK_ACCESS_KEY'],
            ],
        ];
    }

    /**
     * Gets ALL the device, os and browser capabilities from Browserstack and stores them to the drive 
     *
     * @return bool 
     * @access public
     */
    public function capabilities()
    {
        try
        {
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

    /**
     * Writes string to file on drive
     *
     * @param string $fileName  the string of file name
     * @param string $data  the string of data to write to file
     * @return bool 
     * @throws Exception 
     * @access private
     */
    private function writeFile(string $fileName, string $data)
    {
        try {
            $handle = fopen($fileName, 'w');
            if(!$handle)
            {
                throw new Exception("Unable to open file");
                return false;
            }
            fwrite($handle, $data);
            
            if(!fclose($handle))
            {
                throw new Exception("can't close the file resource");
                return false;
            }
            return true;
		} catch (Exception $e) {
            echo "Caught exception: ". $e->getMessage(). ".\n";
            return false;
		}
    }
}

$method = getenv('METHOD');
if ($method)
{
    $prog = new BrowserStackMethods();
    $prog->capabilities();
}
