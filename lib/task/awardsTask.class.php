<?php

class awardsTask extends sfPropelBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'recording'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = 'recording';
    $this->name             = 'awards';
    $this->briefDescription = 'Assigns users new Awards';
    $this->detailedDescription = <<<EOF
The [awards|INFO] task checks for new awards.
Call it with:

  [php symfony awards|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);

    // load the Url helper inside task to avoid: The "default" context does not exist.
//    $this->context = sfContext::createInstance($this->configuration);
//    $this->context->getConfiguration()->loadHelpers('Url');
    
    $result = UserAward::giveAwards();

    // add your code here
  }
}
