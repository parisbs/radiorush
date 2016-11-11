# RadioRush PHP Library Changelog  
Author: Paris Niarfe Baltazar Salguero
Twitter: @SiegSBDeveloper
E-mail: sieg.sb@gmail.com

## v1.2.0, released on 19:03 10/11/2016  
Minor update with the library documentation and small improvements  
### New  
* Now the library contains documentation  
### Modified  
* Now the infoStream function returns directly the response of the query, so you don't need to use $response['response']->status. Now go directly to the response value: $response['response']->title for example  
### Observations  
* The documentation is generated automatically using [phpDocumentor](https://www.phpdoc.org)

## v.1.1.0, released on 1:39 08/11/2016  
Minor update with improvements in some functions and in the library performance  
### New  
* Performance enhancements by removing unnecessary lines of code  
* Now the Library use completely the standard PSR-2  
### Modified  
* Now the autoRemove function accept a second param to specify the name of the recicle bin folder
* The library returns a more specific error messages for Centova Cast server connection problems

## v1.0.1, released on 0:50 07/11/2016  
Critical update to apply the patch of the composer dependencies  
### Fixed  
* Fix an error with the dependencies on composer.json  
### Modified  
* Now RadioRush requires PHPUnit version 4.8 or higuer

## v1.0.0, released on 0:22 07/11/2016
This is the first release of RadioRush Library  
### Added  
* getAuthenticate to verify if the Centova credentials exists  
* Methods to manage playlist (add, remove, activate and deactivate)  
* Methods to get the account and the streaming info  
* Methods to turn on and off the autoDJ  
* Methods to start, stop, reset and restart the radio  
* Method to refresh and check the status of the Centova storage on disk  
