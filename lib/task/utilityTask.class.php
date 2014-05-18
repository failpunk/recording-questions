<?php

class utilityTask extends sfPropelBaseTask
{
    protected function configure()
    {
        // add your own arguments here
        $this->addArguments(array(
                new sfCommandArgument('tool', sfCommandArgument::REQUIRED, 'What utility to run, seperate multiple with space?'),
        ));

        $this->addOptions(array(
                new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'recording'),
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
                // add your own options here
        ));

        $this->namespace        = 'recording';
        $this->name             = 'utility';
        $this->briefDescription = 'Performs Various Utility Tasks';
        $this->detailedDescription = <<<EOF
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

        $toolNames = array(
                'resetvote',
                'stats',
                'recalc',
                'backup',
                'tweet',
                'newsletter-sync'
        );

        if($arguments['tool'] == 'resetvote')
        {
            UserPeer::resetDailyVotingLimit();
        }
        elseif($arguments['tool'] == 'stats')
        {
            $mail = new Mail();
            $mail->sendSystemStatusEmail();
        }
        elseif($arguments['tool'] == 'recalc')
        {
            Experience::recalcAllUsers();
        }
        elseif($arguments['tool'] == 'tweet')
        {
            $this->context = sfContext::createInstance($this->configuration);
            $this->context->getConfiguration()->loadHelpers('Url');

            $questions = QuestionPeer::getUntweetedQuestions();

            foreach($questions as $question)
            {
                $question->sendTweets(true);
                $question->setTweeted(1);
                $question->save();
            }
        }
        elseif($arguments['tool'] == 'backup')
        {
            $this->backupDatabase('record_production');
            $this->backupDatabase('record_blog');
        }
        elseif($arguments['tool'] == 'newsletter-sync')
        {
            $mailChimp = new Mailchimp();
            $mailChimp->syncronizeEmails();
        }
        else
        {
            echo "Not a valid tool name.  Try: ";
            foreach($toolNames as $tool)
                echo $tool . ",";
            echo "\n";
        }
    }

    private function backupDatabase($schema)
    {
        $fileName =  date('Ymd') . '-' . $schema . '.sql';

        // dump the database to an sql file and zip it
        $sqlMsg  = shell_exec('mysqldump -u record_web -pshibay0de1 ' . $schema . ' > ' . $fileName);
        $gzipMsg = shell_exec('gzip ' . $fileName);

        // ftp the file to the apetrax server for archive, and log
        $curlMsg = shell_exec('curl -u apetrax:rulethemall -T ' . $fileName . '.gz ftp.apetraxstudios.com/recordingquestions/');
        ProcessLogPeer::addLog('dbBackup', "Database backup of $schema");
    }
}
