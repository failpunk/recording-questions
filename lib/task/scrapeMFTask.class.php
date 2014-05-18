<?php

class scrapeMFTask extends sfBaseTask
{
  protected $sections = array(
      'interface',
      'monitors',
      'microphones',
      'software',
      'other',
      'rack',
      'plugins',
      'preamps',
      'compressors',
      'mixers',
      'headphones',
      'instruments',
      'equalizers'
   );

  protected function configure()
  {
    $this->addOptions(array(
        new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'recording'),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
        new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
        // add your own options here
    ));

    $this->namespace = 'recording';
    $this->name = 'scrape';
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
//        $this->context->getConfiguration()->loadHelpers('Partial');

//    $links = AffiliateLinkPeer::getProAudioLinks();
    $links = AffiliateLinkPeer::getBySku(244523);

    $links = array($links);
//$sections = array();
    foreach($links as $link)
    {
      // create company
      $company = $this->createCompany($link);

      $userId = 4;    // recordingquestions id

      $gearName = $this->getGearName($link);
      $section = $this->getSection($link);

      // don't load all the wireless crap
      if($section == 'Wireless Systems')
        continue;

      $page = file_get_contents($link->getBuyUrl());
      $descriptionText = $this->extractHtmlBetween($page, '"leftCopy"', '</p>');
      $SpecsText = $this->extractSpecs($page);

      $imageUrl = $this->extractImageUrl($page);


      $gear = new Gear();
      $gear->setName($gearName);
      $gear->setSearchName(myUtil::unslugify($gearName));
      $gear->setCategoryId(1);
      $gear->setCompanyId($company->getId());
      $gear->setSection($section);

      // save about data to gear_info table
      $gear_info = new GearInfo();
      $gear_info->setUserId($userId);
      $gear_info->setAbout(myUtil::cleanText(trim($descriptionText)));
      $gear_info->setSpecs(myUtil::cleanText(trim($SpecsText)));

      $gear_info->setIp('192.168.1.1');

      $gear->addGearInfo($gear_info);

      $tag_id = $this->createTag($gearName);

      $gear->save();

      $gearTag = new GearTag();
      $gearTag->setGearId($gear->getId());
      $gearTag->setTagId($tag_id);
      $gearTag->save();

      // get the image, process and save it.
      $imageName = $this->saveImage($imageUrl, 'gear_' . $gear->getId() . '.jpg');

      myUtil::resizeGearImages($imageName, sfConfig::get('app_gear_gear_images'), $gear->getId(), 'web/images/');
    }
  }

  protected function createCompany(AffiliateLink $link)
  {
    $companyName = trim($link->getCompany());

    $company = GearCompanyPeer::getCompanyByName($companyName);

    if($company)
      return $company;

    $company = new GearCompany();
    $company->setupNewCompany($companyName);

    return $company;
  }

  protected function getGearName(AffiliateLink $link)
  {
    $name = str_replace($link->getCompany(), '', $link->getName());  // remove company from name
    $name = preg_replace("/&#?[a-z0-9]+;/i", '', $name); // remove entities
    $name = str_replace('"', '', $name);
    $name = trim($name);

    return $name;
  }

  protected function getSection(AffiliateLink $link)
  {
    $parts = explode('>', $link->getCategory());

    if(array_key_exists(1, $parts))
    {
      $parts[1] = trim($parts[1]);
      
      if($parts[1] == 'Signal Processors' || $parts[1] == 'Software')
        $section = trim($parts[2]);
      else
        $section = trim($parts[1]);
    }
    else
      $section = 'other';


    return $section;
  }

  protected function extractHtmlBetween($html, $startString, $endString)
  {
    $pos = strpos($html, $startString);
    $html = substr($html, $pos + 11);

    $endPos = strpos($html, $endString);
    $html = substr($html, 0, $endPos);

    return str_replace('<br>', "\n", $html);
  }

  protected function extractSpecs($html)
  {
    $pos = strpos($html, 'id="specifications"');

    if($pos === false)
      return '';

    $html = substr($html, $pos - 4);

    $endPos = strpos($html, '</ul>');
    $html = substr($html, 0, $endPos + 5);

    return $html;
  }

  protected function extractImageUrl($html)
  {
    $pos = strpos($html, 'id="strImage"');

    if($pos === false)
      return '';

    $html = substr($html, $pos + 14, 500);

    $html = trim(strtolower($html));

    $pos = strpos($html, 'http');
    $html = substr($html, $pos);

    $endPos = strpos($html, '.jpg');
    $url = substr($html, 0, $endPos + 4);

    return $url;
  }

  protected function saveImage($imageUrl, $name)
  {
    $image = ImageCreateFromJPEG($imageUrl);
    imagejpeg($image, sfConfig::get('sf_upload_dir') . '/' . $name);
    return $name;
  }

  protected function createTag($name)
  {
    $parts = explode(' ', $name);

    $tagName = '';

    // max of 4 words
    foreach($parts as $i => $word)
    {
      $tagName .= $word . ' ';
      if($i >= 4)
        break;
    }

    $tagName = myUtil::slugify(trim($tagName));
    
    $tag = new Tag();
    $tag->setName($tagName);
    $tag->save();

    // Ensure the other things are prepared to add new gear
    return $tag->getID();
  }
}
