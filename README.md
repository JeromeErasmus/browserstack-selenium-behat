# behat-browserstack
[Behat](https://github.com/Behat/Behat) Integration with BrowserStack.

## Setup
* Clone the repo into your project root
* Cd into the repo folder on your local machine
* Install dependencies `composer install`
* First copy dist.*.conf.yml to `*.conf.yml` and then edit them to match your project path specifications. e.g. dist.local.conf.yml is saved as a new file local.conf.yml
* create a new .env file in the config folder .env file from the .dist.env file and update with your browserstack keys

## Running your tests
- To run a single test, run `composer single`
- To run local tests, run `composer local`
- To run parallel tests, run `composer parallel`

## Notes
* You can view your test results on the [BrowserStack Automate dashboard](https://www.browserstack.com/automate)
* To test on a different set of browsers, check out our [platform configurator](https://www.browserstack.com/automate/php#setting-os-and-browser)
  