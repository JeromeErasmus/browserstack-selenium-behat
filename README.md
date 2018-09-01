# About this Library
This library is to assist  Selenium and Browserstack Continious Integration with for BeHat testing in native PHP. There are three ways to setup and run the tests:
* **Running Selenium tests locally**
* **Running Selenium tests in Docker (with bitbucket Pipelines)**
* **Running the Browserstack**

The library can be installed into your PHP project using the below composer command  which will install the library from Packagist.
```
require jeromeerasmus/selenium-automate:dev-master
```

# Running Selenium tests locally

### Requirements
Requires Firefox v39.0 with Selenium v1.4.0
You can download the correct version of Firefox here: https://ftp.mozilla.org/pub/firefox/releases/39.0/
Remember to turn automatic updates off Firefox as soon as it is installed.

### Setup

First grab the latest JRE and install it on your machine as Selenium runs on the JRE. You first need to install selenium on your machine in order to run the Selenium tests. On OSX this should be as easy as: 
```
brew install selenium-server-standalone
```

Next configure your composer.json file with the below commands to be able to run the Selenium tests locally.
```
"scripts": {
    "start-selenium": "vendor/bin/manager start",
    "run-selenium": "vendor/bin/behat --config=conf.selenium.yml -f pretty -o std -f junit -o results"
  }
```
Next, copy dist.conf.selenium.yml and dist.conf.browserstack.yml to conf.selenium.yml and conf.browserstack.yml and then edit them to match your project specifications. You will only need to edit the **base_url** field for this config. 

### Executing the tests
Then perform the below:
First start Selenium in a new terminal window. Leave it running.
```
composer start-selenium
```

Then open up a new terminal window and run the sample tests with: 
```
composer run-selenium
```


# Running Selenium tests in Docker (with bitbucket Pipelines)
This configuration allows you to run your tests with Docker.

### Requirements
Docker and Docker Compose installed on your machine. (of course)

### Setup 
In the root folder perform the below steps:
1. Create a Dockerfile with the below contents:
    ```
    FROM mycrm/base
    
    COPY . /var/specs
    WORKDIR /var/specs
    
    # Config
    ENTRYPOINT ["vendor/bin/behat"]
    ```

2. Create a docker-compose file with the below contents:
    ```
    version: '2'
    services:
      specs:
        build: .
        volumes:
          - .:/var/specs
        container_name: mycrm-specs
        links:
         - firefox-server
        environment:
          BEHAT_PARAMS: '{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "https://it.wikipedia.org/"}}}'
    
      firefox-server:
        container_name: mycrm-specs-server
        #image: selenium/standalone-firefox-debug:2.53.0
        image: selenium/standalone-firefox:2.53.0
        ports:
          - "4444:4444"
          - "5900:5900"
    ```
Now you can execute the below command which will build the Docker images and run the tests. 
```
docker-compose -f docker-compose.yml run --rm specs  --config=conf.selenium-docker.yml
```

### Setup Bitbucket Pipelines script
You can run the tests on Bitbucket Pipelines by creating the below bitbucket-pipelines.yml file in your root folder. You can use the below script for the contents.
```
pipelines:
  default:
    - step:
        image: jeromeerasmus/docker-alpine-php-composer:7.0
        services:
          - docker
        script: 
          - composer install
          - docker-compose -f docker-compose.yml run --rm specs  --config=conf.selenium-docker.yml
```



# Selenium Automate (with Browserstack)

[Behat](https://github.com/Behat/Behat) Integration with BrowserStack.
## Setup
* Clone the repo into your project root
* Cd into the repo folder on your local machine
* Install dependencies `composer install`
* First copy dist.conf.selenium.yml and dist.conf.browserstack.yml to conf.selenium.yml and conf.browserstack.yml and then edit them to match your project specifications.
* Then copy the dist.env file to .env and update with your browserstack keys



### Creating the capabilities config
You define a capabilities configuration file to explicity set which browsers / devices / operating systems you will test on. To get the full updated list of capabilities from browserstack run the following command:
```
composer capabilities
```

This will bring down an exhaustive list of ALL capabilities. Look through the list and pick out the capabilities you want to run your tests on. You can use these capabilities to update your .yml files

Once the above is done correctly you will be able to run your tests.


```












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
  