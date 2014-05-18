<?php

# FROZEN_SF_LIB_DIR: /usr/lib/php/symfony12/lib
require_once 'symfony/autoload/sfCoreAutoload.class.php';
//require_once '../symfony/symfony-1.2.7/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin'));
  }
}
