<?php
/**
 * Use this class to interface with the Mail Chimp API
 */

class Mailchimp
{
    static $db = array(
        'host' => 'localhost',
        'username' => '',
        'passwd' => '',
        'dbname' => ''
    );
    
    static $cols = array(
        'email' => 'EMAIL',
        'display_name' => 'FNAME',
    );
    
    static $existsQuery = 'SELECT COUNT(user_id) FROM user WHERE email_on = 1';
    static $selectQuery = 'SELECT email, display_name FROM user WHERE email_on = 1';

    public function  __construct()
    {
        $db = Propel::getConfiguration('propel');
        $db = $db['datasources']['propel']['connection'];
        
        $parts = explode(';', $db['dsn']);
        $dbname = explode('=', $parts[0]);
        
        self::$db['dbname'] = $dbname[1];
        self::$db['username'] = $db['user'];
        self::$db['passwd'] = $db['password'];
    }

    static public function syncronizeEmails()
    {
        try
        {
            $synchronizer = new Galahad_MailChimp_Synchronizer_Mysqli(sfConfig::get('app_mailchimp_username'), sfConfig::get('app_mailchimp_password'), self::$db);
            $synchronizer->sync(sfConfig::get('app_mailchimp_newsletter_id'), self::$selectQuery, self::$existsQuery, self::$cols);
            echo "\nSynced:\n";

            // Print out log of sync actions
            foreach ($synchronizer->getBatchLog() as $entry) {
                echo "\n - {$entry}";
            }

            // Any individual errors
            $errors = $synchronizer->getBatchErrorLog();
            if ($errors) {
                echo "\nErrors:\n";
                foreach ($errors as $batch => $batchErrors) {
                    echo "\n{$batch}:";
                    foreach ($batchErrors as $error) {
                        echo "\n - {$error['message']}";
                    }
                }
            }

        } catch (Galahad_MailChimp_Synchronizer_Exception $e) {
            echo "\nError syncing:\n\n";
            echo $e->getMessage();
        }
    }
}
?>