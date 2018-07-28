# behat-browserstack
[Behat](https://github.com/Behat/Behat) Integration with BrowserStack.

## Setup
* Clone the repo into your project root
* Cd into the repo folder on your local machine
* Install dependencies `composer install`
* First copy dist.*.conf.yml to `*.conf.yml` and then edit them to match your project path specifications. e.g. dist.local.conf.yml is saved as a new file local.conf.yml
* create a new .env file in the config folder .env file from the .dist.env file and update with your browserstack keys

### Creating the capabilities config
You define a capabilities configuration file to explicity set which browsers / devices / operating systems you will test on. To get the full updated list of capabilities from browserstack run the following command:
```
composer capabilities
```

This will bring down an exhaustive list of ALL capabilities. Look through the list and pick out the capabilities you want to run your tests on. Create a new file in the config folder called capabilities_set.json and copy the capabilities you want to test on into the file. Use the dist.capabilities_set.json as a guide. 

## define where your tests reside in your project
Each project has unique tests associated with it. This library takes into account that you may have a variety of different project structures and that your test may be located in different locations from project to project. To point the to your files configure your config/*.yml files to your test paths. by default they are as follows:
```
default:
    paths:
        features: '../features/single'
``` 

Once the above is done correctly you will be able to run your tests.

## Running your tests
- To run a single test, run `composer single`
- To run local tests, run `composer local`
- To run parallel tests, run `composer parallel`

## Notes
* You can view your test results on the [BrowserStack Automate dashboard](https://www.browserstack.com/automate)
* To test on a different set of browsers, check out our [platform configurator](https://www.browserstack.com/automate/php#setting-os-and-browser)
  