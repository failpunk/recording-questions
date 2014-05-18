<?php

class mailTask extends sfBaseTask
{
    protected function configure()
    {
        // add your own arguments here
        $this->addArguments(array(
                new sfCommandArgument('user', sfCommandArgument::OPTIONAL, 'Provide a user id to send email to only that user'),
        ));
        
        $this->addOptions(array(
                new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'recording'),
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
                // add your own options here
        ));

        $this->namespace        = 'recording';
        $this->name             = 'mail';
        $this->briefDescription = 'Sends out emails';
        $this->detailedDescription = <<<EOF
The [mail|INFO] task does things.
Call it with:

  [php symfony mail|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);

        $this->context = sfContext::createInstance($this->configuration);
        $this->context->getConfiguration()->loadHelpers('Partial');

        $userId = '';

        if($arguments['user']) {
            $userId = $arguments['user'];
        }

        // add your code here
        $mail = new Mail();
        $mail->sendUpdateEmail($userId);
    }
}
