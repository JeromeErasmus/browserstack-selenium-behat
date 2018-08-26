# Selenium Automate (with Browserstack)
[Behat](https://github.com/Behat/Behat) Integration with BrowserStack.

## Setup
* Clone the repo into your project root
* Cd into the repo folder on your local machine
* Install dependencies `composer install`
* First copy dist.conf.selenium.yml and dist.conf.browserstack.yml to conf.selenium.yml and conf.browserstack.yml and then edit them to match your project specifications.
* Then copy the dist.env file to .env and update with your browserstack keys

## Requirements
Requires Firefox v39.0 with Selenium v1.4.0
You can download the correct version of Firefox here: https://ftp.mozilla.org/pub/firefox/releases/39.0/
Remember to turn automatic updates off Firefox as soon as it is installed.

### Creating the capabilities config
You define a capabilities configuration file to explicity set which browsers / devices / operating systems you will test on. To get the full updated list of capabilities from browserstack run the following command:
```
composer capabilities
```

This will bring down an exhaustive list of ALL capabilities. Look through the list and pick out the capabilities you want to run your tests on. You can use these capabilities to update your .yml files

Once the above is done correctly you will be able to run your tests.

## Running the Selenium tests 
First grab the latest JRE and install it on your machine as Selenium runs on the JRE. You first need to install selenium on your machine in order to run the Selenium tests. On OSX this should be as easy as: 
```
brew install selenium-server-standalone
```


Then perform the below:
First start Selenium 
```
composer start-selenium
```

Then run the test 
```
composer run-selenium
```

## Running the Browserstack tests 
To run a test in browserstack execute 
```
composer run-bs
```


### Manufaturing tests by the dozen
The below is some basic workflow tips to save you some time. The below is not essential to running your tests.

Scaffold a BeHat project structure and key files
```
./bin/behat --init
```

After writing your .feature file run the below to create the code snippet and auotmoatically place it into the 
Feature context file
```
./bin/behat --append-snippets
```

## Notes
* You can view your test results on the [BrowserStack Automate dashboard](https://www.browserstack.com/automate)
* To test on a different set of browsers, check out  [platform configurator](https://www.browserstack.com/automate/php#setting-os-and-browser)
  