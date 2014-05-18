<?php

class sitemapTask extends sfBaseTask
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
    $this->name             = 'sitemap';
    $this->briefDescription = 'Generates an XML sitemap';
    $this->detailedDescription = <<<EOF
This will generate an XML sitemap for the site:

  [php symfony sitemap|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here
    $sitemap = new Sitemap();
    $sitemap->createSitemaps();

    // let bing know we updated the sitemap
    $sitemap_address = urlencode('http://recordingquestions.com/sitemap_index.xml');
    
    // Bing
    $bing = file_get_contents('http://www.bing.com/webmaster/ping.aspx?siteMap='.$sitemap_address);
    
    // Google
    $google = file_get_contents('http://www.google.com/webmasters/sitemaps/ping?sitemap='.$sitemap_address);

    // Ask
    $ask = file_get_contents('http://submissions.ask.com/ping?sitemap='.$sitemap_address);

    // Yahoo
    $yahoo = file_get_contents('http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=YahooDemo&url='.$sitemap_address);
  }
}
