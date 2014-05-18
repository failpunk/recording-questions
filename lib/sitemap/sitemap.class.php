<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Sitemap
{
    private $_max_links_per_file = 50000;

    // Basic name of link files to be generated
    private $_filename = "sitemap";

    // Name of sitemap index file.
    private $_indexFilename = "sitemap_index.xml";

    private $_XMLBlank      = '<?xml version="1.0" encoding="UTF-8"?>';
    private $_XMLUrlSet     = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
    private $_sitemapindex  = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>';

    private $_urlBase       = "http://recordingquestions.com/";
    private $_webDirectory;

    private $_minVote;
    private $_maxVote;
    private $_voteRange;
    private $_priorityIncrement;

    // Array of sitemap link files created during process
    private $_sitemapFiles = array();

    
    public function createSitemaps()
    {
        $this->_webDirectory = sfConfig::get('sf_web_dir') . "/";
        $this->setMinMaxVotes();

        $this->createQuestionSitemapFiles();

        if(sfConfig::get('app_gear_enable'))
        {
            $this->createGearSitemapFiles();
            $this->createCompanySitemapFiles();
            $this->createReviewSitemapFiles();
        }
        
        $this->createIndexFile();
    }

    private function createIndexFile()
    {
        // create basic xml skeleton
        $xmlHeader = $this->_XMLBlank . "\n\t" . $this->_sitemapindex;
        $xmlobj = simplexml_load_string($xmlHeader);

        // add the file of static pages (generated manually)
//        $filename = 'sitemap_statics.xml.gz';
//
//        $urlobj = $xmlobj->addChild("sitemap");
//        $urlobj->addChild('loc', $this->_urlBase . $filename);
//
//        if (file_exists($this->_webDirectory . $filename)) {
//            $urlobj->addChild('lastmod', date ("Y-m-d", filemtime($this->_webDirectory . $filename)));
//        }
        
        // Add an element for each sitemap file
        foreach($this->_sitemapFiles as $name)
        {
            $urlobj = $xmlobj->addChild("sitemap");
            
            // build link url
            $url = $this->_urlBase . $name;
            
            $urlobj->addChild('loc', "$url");
            $urlobj->addChild('lastmod', date('Y-m-d'));
        }
        
        // save to XML file
        file_put_contents($this->_webDirectory . $this->_indexFilename, $xmlobj->asXML());
    }

    private function createQuestionSitemapFiles()
    {
        // Question Files
        $questionCount = QuestionPeer::getCountQuestions();
        $files = ceil($questionCount / $this->_max_links_per_file);

        // break sitemaps in to files containing 50k links each
        for($i=0; $i < $files; $i++)
        {
            $limit = $this->_max_links_per_file;
            $questions = QuestionPeer::getQuestionsForSitemap($limit, $limit * $i);
            $this->buildQuestionSitemapFile($questions, $i);
        }
    }

    private function createGearSitemapFiles()
    {
        // Get page counts
        $gearCount = GearPeer::getCount();
        $files = ceil($gearCount / $this->_max_links_per_file);

        // break sitemaps in to files containing 50k links each
        for($i=0; $i < $files; $i++)
        {
            $limit = $this->_max_links_per_file;
            $gear = GearPeer::getGearForSitemap($limit, $limit * $i);
            $this->buildGearSitemapFile($gear, $i);
        }
    }

    private function createCompanySitemapFiles()
    {
        // Get page counts
        $companyCount = GearCompanyPeer::getCount();
        $files = ceil($companyCount / $this->_max_links_per_file);

        // break sitemaps in to files containing 50k links each
        for($i=0; $i < $files; $i++)
        {
            $limit = $this->_max_links_per_file;
            $companies = GearCompanyPeer::getCompaniesForSitemap($limit, $limit * $i);
            $this->buildCompanySitemapFile($companies, $i);
        }
    }

    private function createReviewSitemapFiles()
    {
        // Get page counts
        $reviewCount = GearReviewPeer::getCount();
        $files = ceil($reviewCount / $this->_max_links_per_file);

        // break sitemaps in to files containing 50k links each
        for($i=0; $i < $files; $i++)
        {
            $limit = $this->_max_links_per_file;
            $reviews = GearReviewPeer::getReviewsForSitemap($limit, $limit * $i);
            $this->buildReviewSitemapFile($reviews, $i);
        }
    }

    private function buildQuestionSitemapFile($questions, $fileSuffix)
    {
        // create basic xml skeleton
        $xmlHeader = $this->_XMLBlank . "\n\t" . $this->_XMLUrlSet;
        $xmlobj = simplexml_load_string($xmlHeader);

        foreach($questions as $question)
        {
            $urlobj = $xmlobj->addChild("url");

            // build link url
            $url = $this->_urlBase . "question/" . myUtil::createSlug($question['Title']) . "/" . $question['Id'];

            $urlobj->addChild('loc', "$url");
            $urlobj->addChild('priority', $this->determinePriority($question['Upvotes'], $question['Downvotes']));
            $urlobj->addChild('changefreq', $this->getFrequency($question['UpdatedAt']));
        }

        $file = $this->constructFileLocation('sitemap-questions', $fileSuffix);

        // save to XML file
        file_put_contents($file, $xmlobj->asXML());

        // gzip XML file
        shell_exec('gzip --force ' . $file);
    }

    private function buildGearSitemapFile($gears, $fileSuffix)
    {
        // create basic xml skeleton
        $xmlHeader = $this->_XMLBlank . "\n\t" . $this->_XMLUrlSet;
        $xmlobj = simplexml_load_string($xmlHeader);

        foreach($gears as $gear)
        {
            $urlobj = $xmlobj->addChild("url");

            // build link url
            $url  = $this->_urlBase . "gear/";
            $url .= myUtil::slugify($gear['GearCompany.Name']) . "/" ;
            $url .= myUtil::slugify($gear['Gear.Name']) . "/" ;
            $url .= $gear['Gear.Id'];

            $urlobj->addChild('loc', $url);
            $urlobj->addChild('lastmod', date('Y-m-d', strtotime($gear['Gear.UpdatedAt'])));
        }

        $file = $this->constructFileLocation('sitemap-gear', $fileSuffix);

        // save to XML file
        file_put_contents($file, $xmlobj->asXML());

        // gzip XML file
        shell_exec('gzip --force ' . $file);
    }

    private function buildCompanySitemapFile($companies, $fileSuffix)
    {
        // create basic xml skeleton
        $xmlHeader = $this->_XMLBlank . "\n\t" . $this->_XMLUrlSet;
        $xmlobj = simplexml_load_string($xmlHeader);

        foreach($companies as $company)
        {
            $urlobj = $xmlobj->addChild("url");

            // build link url
            $url  = $this->_urlBase . "gear/";
            $url .= myUtil::slugify($company['GearCompany.Name']);

            $urlobj->addChild('loc', $url);
            $urlobj->addChild('lastmod', date('Y-m-d', strtotime($company['GearCompany.UpdatedAt'])));
        }

        $file = $this->constructFileLocation('sitemap-companies', $fileSuffix);

        // save to XML file
        file_put_contents($file, $xmlobj->asXML());

        // gzip XML file
        shell_exec('gzip --force ' . $file);
    }

    private function buildReviewSitemapFile($reviews, $fileSuffix)
    {
        // create basic xml skeleton
        $xmlHeader = $this->_XMLBlank . "\n\t" . $this->_XMLUrlSet;
        $xmlobj = simplexml_load_string($xmlHeader);

        foreach($reviews as $review)
        {
            $urlobj = $xmlobj->addChild("url");

            // build link url
            $url  = $this->_urlBase . "gear/";
            $url .= myUtil::slugify($review['GearCompany.Name']) . "/";
            $url .= myUtil::slugify($review['Gear.Name']) . "/";
            $url .= $review['GearReview.GearId'] . "/";
            $url .= "review/";
            $url .= myUtil::slugify($review['GearReview.Title']) . "/";
            $url .= $review['GearReview.Id'];

            $urlobj->addChild('loc', $url);
            $urlobj->addChild('lastmod', date('Y-m-d', strtotime($review['GearReview.UpdatedAt'])));
        }

        $file = $this->constructFileLocation('sitemap-reviews', $fileSuffix);

        // save to XML file
        file_put_contents($file, $xmlobj->asXML());

        // gzip XML file
        shell_exec('gzip --force ' . $file);
    }

    private function constructFileLocation($fileBase, $fileSuffix )
    {
         $newFile = $fileBase . $fileSuffix . ".xml";

         // store file with gzip extention for sitemap index creation.
         $this->_sitemapFiles[] = $newFile . ".gz";

         return $this->_webDirectory . $newFile;
    }

    private function getFrequency($lastModified)
    {
        $elapsedDays = (time() - strtotime($lastModified)) / 86400;

        switch ($elapsedDays) {
            case ($elapsedDays < 1):
                return 'hourly';
                break;
            case ($elapsedDays < 7):
                return 'daily';
                break;
            case ($elapsedDays < 30):
                return 'weekly';
                break;
            case ($elapsedDays < 365):
                return 'monthly';
                break;
            default:
                return 'yearly';
                break;
        }
    }

    private function setMinMaxVotes()
    {
        $this->_minVote = QuestionPeer::getLowestVoteCount();
        $this->_maxVote = QuestionPeer::getHighestVoteCount();
        $this->_voteRange = $this->_minVote + $this->_maxVote;
        $this->_priorityIncrement = 1 / $this->_voteRange;
    }

    /**
     *  This will determine the questions priority in the sitemap range (0 - 1).
     */
    private function determinePriority($upvotes, $downvotes)
    {
        $voteweight = $upvotes - $downvotes;
        $priority = round(($voteweight + $this->_minVote) * $this->_priorityIncrement, 2);

        if($priority > 1) {
            $priority = 1;
        }
        
        return $priority;
    }
}
