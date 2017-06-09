# RadioRush [![Build Status](https://travis-ci.org/SiegSB/radiorush.svg?branch=master)](https://travis-ci.org/SiegSB/radiorush)  
Complete PHP library for the Centova Cast API.

## With this PHP library you can  
* Make request to your Centova Cast API  
* Autoformat or dump the responses as arrays or json objects  
* Make multiples instances with diferents users of your Centova Cast Panel  
* This library returns only the usefully data of the API responses  
 
## Requirements  
* PHP 5.4 orhigher  
* CURL PHP extension (optional but recomended)  
* Param "*allows_include_url*" enabled in your PHP.ini
 
## How to install and use  
You can install RadioRush via Composer adding the following line to your require array on your composer.json:  
    "siegsb/radiorush":"*"  

After run "*composer update*" on the terminal. Now you can use RadioRush with the autoload.php file.  
The namespace is \SiegSB\RadioRush so you can include the library on your code with this:  

    <?php  
    require_once ('vendor/autoload.php');  
    use \SiegSB\RadioRush;  
    ....  
    // Now you can creates a new instance of RadioRush  
    $rr = new RadioRush;  
    // Also you can define directly the namespace in your instance  
    // Use this instance method if you do not want to use 'use \SiegSB\RadioRush;'  
    $rr = new \SiegSB\RadioRush\RadioRush;

After this, you need to create a new connection with your Centova server using the method "*setConnect*" with the following params:  
* string $server: the URL of your Centova server without the final slash. For example: "*http://centova.example.com*"  
* string $username: The username of your Centova account  
* string $password: the password in plain text of your Centova account

    $rr->setConnect('http://centova.example.com', 'username', 'password');

When you set a new connect, you can make requests to Centova API. If you want to use another connect you can overwrite the setConnect method with the new params or create a diferent instance of RadioRush.

If you want to make a donation, please use Paypal and send your donation to the email sieg.sb@gmail.com, thanks!