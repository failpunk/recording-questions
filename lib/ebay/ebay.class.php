<?php
class Ebay
{
    static $service_version    = '1.0.0';
    static $production_gateway = 'http://svcs.ebay.com/services/search/FindingService/v1';
    static $format = 'JSON';
    static $sort_order = 'PricePlusShippingLowest';

    static public function findProduct($keywords, $maxResults = 3)
    {
        $appid = sfConfig::get('app_ebay_appid');
        $method  = 'findItemsByKeywords';

        $apiUrl  = self::$production_gateway;
        $apiUrl .= '?OPERATION-NAME=' . $method;
        $apiUrl .= '&SERVICE-VERSION=' . self::$service_version;
        $apiUrl .= '&SECURITY-APPNAME=' . $appid;
        $apiUrl .= '&RESPONSE-DATA-FORMAT=' . self::$format;
        $apiUrl .= '&GLOBAL-ID=EBAY-US';
        $apiUrl .= '&REST-PAYLOAD';
        $apiUrl .= '&keywords=' . urlencode($keywords);
        $apiUrl .= '&paginationInput.entriesPerPage=' . $maxResults;
        $apiUrl .= '&affiliate.networkId=9';
        $apiUrl .= '&affiliate.trackingId=' . sfConfig::get('app_ebay_campid');
        $apiUrl .= '&sortOrder=' . self::$sort_order;

        $results = self::callApi($apiUrl);

        if($results)
        {
            $results = $results->findItemsByKeywordsResponse[0];

            // Log Api call errors
            if($results->ack[0] != 'Success') {
                $message = 'Ebay API Error: ' . $results->errorMessage;
                sfContext::getInstance()->getLogger()->err($message);
            }

            if($results->searchResult[0]->{"@count"} > 0)
                return $results->searchResult[0]->item;
            else
                return array();
        }
        
        return array();
    }

    static private function callApi($url)
    {
        if(!sfConfig::get('app_ebay_enable')) {
            return false;
        }

        $results = json_decode(file_get_contents($url));
        
        if($results)
        {
            return $results;
        }
        else
        {
            return false;
        }
    }

    static public function timeFromEbayTime($eBayTimeString)
    {
        // Input is of form 'PT12M25S'
        $matchAry = array(); // initialize array which will be filled in preg_match
        $pattern = "#P([0-9]{0,3}D)?T([0-9]?[0-9]H)?([0-9]?[0-9]M)?([0-9]?[0-9]S)#msiU";
        preg_match($pattern, $eBayTimeString, $matchAry);

        $days  = (int) $matchAry[1];
        $hours = (int) $matchAry[2];
        $min   = (int) $matchAry[3];    // $matchAry[3] is of form 55M - cast to int
        $sec   = (int) $matchAry[4];

        $retnStr = '';
        if ($days)  { $retnStr .= "$days day" . self::pluralS($days);  }
        if ($hours) { $retnStr .= " $hours h"; }
        if ($min)   { $retnStr .= " $min min";   }
//        if ($sec)   { $retnStr .= " $sec sec";   }

        return trim($retnStr);
    }

    static public function pluralS($intIn) {
        // if $intIn > 1 return an 's', else return null string
        if ($intIn > 1) {
            return 's';
        } else {
            return '';
        }
    }

    static public function getPic($result)
    {
        return $result->galleryURL[0];
    }

    static public function getLink($result)
    {
        return $result->viewItemURL[0];
    }

    static public function getPrice($result)
    {
        return $result->sellingStatus[0]->currentPrice[0]->{"__value__"};
    }

    static public function getTimeLeft($result)
    {
        $ebayTime = $result->sellingStatus[0]->timeLeft[0];
        return self::timeFromEbayTime($ebayTime);
    }

    static public function getTitle($result)
    {
        return $result->title[0];
    }
}
?>