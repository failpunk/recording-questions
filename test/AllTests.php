<<?php
require_once 'PHPUnit/Framework.php';
 
define( 'SF_APP_NAME', 'recording' );
define( 'SF_ENV', 'test' );
define( 'SF_CONN', 'propel' );
 
if ( SF_APP_NAME != '' )
{
    require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
    AllTests::$configuration = ProjectConfiguration::getApplicationConfiguration( SF_APP_NAME , SF_ENV, true);
    sfContext::createInstance(AllTests::$configuration);
}
 
class AllTests
{
    public static $configuration = null;
    public static $databaseManager = null;
    public static $connection = null;
 
    protected function setUp()
    {
 
        if ( self::$configuration )
        {
            // initialize database manager
            self::$databaseManager = new sfDatabaseManager(self::$configuration);
            self::$databaseManager->loadConfiguration();
 
            if ( SF_CONN ) self::$connection = self::$databaseManager->getDatabase( SF_CONN );
        }
 
    }
 
    public static function suite()
    {
        
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit');
        
        $loader = new PHPUnitSuiteLoader($suite, dirname(__FILE__). '/phpunit');
        $loader->load();
 
        return $suite;
    }
}


class PHPUnitSuiteLoader extends DirectoryIterator
{
    private $suite;

    public function __construct(PHPUnit_Framework_TestSuite $suite, $path)
    {
        parent::__construct($path);
        $this->setSuite($suite);
    }
    
    /**
    * @return PHPUnit_Framework_TestSuite
    */
    public function getSuite()
    {
        return $this->suite;
    }
    
    public function setSuite($suite)
    {
    	$this->suite = $suite;
    }
    

    public function load()
    {
        while ($this->valid())
        {
            if($this->current()->isDir())
            {
                $this->addTestDir();
            }
            else
            {
                $this->addTestCase();
            }
            $this->next();
        }
    }

    public function addTestCase()
    {
        if(preg_match('/\.php$/', $this->getFilename()))
        {
            $this->addTestFile( $this->getPathname() );
        }
    }
    
    public function addTestFile($file)
    {
        return $this->getSuite()->addTestFile($file);
    }
    

    public function addTestDir()
    {
        if(!$this->current()->isDot())
        {
            $loader = new self($this->getSuite(), $this->getPathname() );
            $loader->load();
        }
    }

     
}
