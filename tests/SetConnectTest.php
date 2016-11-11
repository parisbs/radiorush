<?php
require_once ('vendor/autoload.php');
use \SiegSB\RadioRush;

class SetConnectTest extends PHPUnit_Framework_TestCase
{

    public function testSetConnect()
    {
        $rr_test = new RadioRush();
        $rr_test->setConnect('https://centova.test', 'username', 'password');
        $this->assertTrue(isset($rr_test));
    }
}
