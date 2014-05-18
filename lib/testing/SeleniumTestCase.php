<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
 
class SeleniumTestCase extends PHPUnit_Extensions_SeleniumTestCase
{

    public function setUp()
    {
        $this->setBrowser('*iexplore');
        $this->setBrowserUrl($this->getHost());
    }

    public function getHost()
    {
//        return sfContext::getInstance()->getConfiguration()->getHost();
    }
}