<?php
class CJ
{
    private $cj_datafile = "http://2833190:8SuUdARe@datatransfer.cj.com/datatransfer/files/2833190/outgoing/productcatalog/41987/Musician_s_Friend-Musicians_Friend_Product_Catalog.txt.gz";
    private $datafile_name = "Musician_s_Friend-Musicians_Friend_Product_Catalog.txt";

    public function restSearch()
    {
        $url  = 'https://linksearch.api.cj.com/v2/link-search?';
        $url .= http_build_query(array(
                                'website-id' => 3682931,
                                'keywords' => urlencode('motu'),
                                'advertiser-ids' => 1496477
//                                'advertiser-ids' => sfConfig::get('app_cj_advertiser_id')
                            ));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . sfConfig::get('app_cj_key')));

        $curl_results = curl_exec($ch);
        curl_close ($ch);
        
        var_dump($xmlObject = simplexml_load_string($curl_results));
        exit;
    }

    private $_strDeveloperKey = '00902b8ab84b13fd006f84eb28eb37a78b90dd14f9aaccfc08c3394f14f070d1028e91e979462fd7b9291b21b4fec3084cc6a81da0afe46bbcc870c4b193eeda39/776f6b03944721e0fb823d22f002724de01c1765628761008d62ebcde8073e4ec40820b2680e45c2d013e3356ad361cdfa7fab99633c13bc39973649e15e4085';
    private $_strWebsiteID = '3682931';

    public function soapLinks()
    {
        $developerKey = sfConfig::get('app_cj_key');
        $websiteId = sfConfig::get('app_cj_website_id');
        
        $ini = ini_set("soap.wsdl_cache_enabled","0");

        try
        {
            $client = new SoapClient("https://linksearch.api.cj.com/wsdl/version2/linkSearchServiceV2.wsdl", array('trace'=> true));

            //Enter the request parameters for LinkSearch below.
            //For detailed usage of the parameter values, please refer to CJ Web Services online documentation

            $objResult = $client->searchLinks(array("developerKey" => $this->_strDeveloperKey,
                                                    "token" => '',
                                                "websiteId" => $this->_strWebsiteID,
                                            "advertiserIds" => '1496477',
                                             "keywords" => '',
                                             "category" => '',
                                             "linkType" => '',
                                             "linkSize" => '',
                                             "language" => 'en',
                                      "serviceableArea" => 'US',
                                        "promotionType" => '',
                                   "promotionStartDate" => '',
                                     "promotionEndDate" => '',
                                               "sortBy" => '',
                                            "sortOrder" => '',
                                              "startAt" => 0,
                                           "maxResults" => 10));


            // The entire response structure will be printed in the next line
            var_dump($objResult);
            exit;

        } catch (Exception $e){
            echo "There was an error with your request or the service is unavailable.\n";
            print_r ($e);
        }
    }

    public function soapProviders()
    {
        $developerKey = sfConfig::get('app_cj_key');
        $websiteId = sfConfig::get('app_cj_website_id');

        $ini = ini_set("soap.wsdl_cache_enabled","0");

        try
        {
            $client = new SoapClient("https://linksearch.api.cj.com/wsdl/version2/advertiserSearchServiceV2.wsdl", array('trace'=> true));

            //Enter the request parameters for LinkSearch below.
            //For detailed usage of the parameter values, please refer to CJ Web Services online documentation

            $objResult = $client->search(array("developerKey" => $this->_strDeveloperKey,
                                                    "token" => '',
                                                 "keywords" => 'musician',
                                                 "linkType" => '',
                                                 "linkSize" => '',
                                                 "language" => 'en',
                                          "serviceableArea" => 'US',
                                                   "sortBy" => '',
                                                "sortOrder" => '',
                                                  "startAt" => 0,
                                               "maxResults" => 10));


            // The entire response structure will be printed in the next line
            var_dump($objResult);
            exit;

        } catch (Exception $e){
            echo "There was an error with your request or the service is unavailable.\n";
            print_r ($e);
        }
    }

    public function importMusiciansFriendData($download = true)
    {
        if($download)
        {
            // Download file
            shell_exec('wget ' . $this->cj_datafile);

            // Unzip file
            shell_exec('gzip -d '.sfConfig::get('sf_root_dir').'/'.$this->datafile_name.'.gz');
        }

        // Process import file
        $this->loadDataFromFile();

        echo "DONE!";
        exit;
    }

    private function loadDataFromFile()
    {
        $fname = sfConfig::get('sf_root_dir').'/'.$this->datafile_name;
        $fsize = filesize($fname);
        $count = 0;

        // Switch currently active affiliate link table
        $this->updateAffiliateTable();

        $tableName = self::getCurrentTableName();
        echo "Inserting into " . $tableName . "\n\n";
        
        // Truncate import table
        call_user_func(array($tableName, "truncate"));

        $handle = fopen($fname, "r") or die("Couldn't get handle");

        if ($handle)
        {
            while (!feof($handle))
            {
                $buffer = fgets($handle, 4096);

                //skip first row
                if($count != 0)
                {
                    $data = explode('|', $buffer);
                    call_user_func_array($tableName . "::insertLink", array($data));
                }

                $count++;
                if($count % 1000 == 0) {
                    echo round(($count * 4096)/$fsize, 2) . " percent done. $count\n";
                }
            }
            fclose($handle);
        }
    }

    private function updateAffiliateTable()
    {
        $fileName = sfConfig::get('app_search_location') . '/affiliate_table.txt';

        $handle = fopen($fileName, "r") or die("Couldn't get handle");

        if ($handle)
        {
            $buffer = trim(fgets($handle, 4096));

            if($buffer == 'AffiliateLinkImportPeer') {
                $newTable = 'AffiliateLinkPeer';
            } else {
                $newTable = 'AffiliateLinkImportPeer';
            }

            $f = fopen($fileName, 'w');
            fwrite($f, $newTable);
            fclose($f);
        }
    }

    public static function getCurrentTableName()
    {
        $fileName = sfConfig::get('app_search_location') . '/affiliate_table.txt';
        $tableName = "AffiliateLinkPeer";

        $handle = fopen($fileName, "r") or die("Couldn't get handle");
        
        if ($handle)
        {
            $tableName = trim(fgets($handle, 4096));
        }

        return $tableName;
    }
}
?>