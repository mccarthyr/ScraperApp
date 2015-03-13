# ScraperApp

## 1 - How to install the application from GitHub
## 2 - How to install the application via Composer (Packaglist)
## 3 - How to run the application
## 4 - How to run the unit tests

## 1 - How to install the application from Github
Open up a terminal and type the following:

**git clone https://github.com/mccarthyr/ScraperApp.git**

This will install the application and create a directory called 'ScraperApp'.

## 2 - How to install the application via Composer (Packaglist)

Create a directory, called for example 'demoScraperApp'.
Within that create a composer.json file and place the following contents in it:

```
{
    "name": "acme/demoScraperApp",
     "require": {
        "software-desk/scraper-app": "dev-master"
    }
}
```

The run the composer install command. If you have composer set up globally
( https://getcomposer.org/doc/00-intro.md#globally ) then the command will be as follows:

**composer install**

This will create the following directory structure:
vendor/software-desk/scraper-app/SoftwareDesk/ScraperApp

The application is available on Packaglist at
https://packagist.org/packages/software-desk/scraper-app


## 3 - How to run the application
If you installed it via GitHub then change into the ScraperApp directory.
If you installed it via Composer then change into the 
vendor/software-desk/scraper-app/SoftwareDesk/ScraperApp directory.

Now to run the application type the following in the terminal:

**php dataParserApplication.php bbc**

If the 'bbc' argument is missing the application will not run.

## 4 - How to run the unit tests
While still in the same directory, to run the unit tests type the following:

**phpunit**

There is a phpunit.xml file which contains the configuration location for the tests and
will be picked up by the phpunit command and all tests will be executed.









