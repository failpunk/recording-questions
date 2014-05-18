<?php
class Scraper
{
    private $_base_url = "http://www.sweetwater.com";


    public function scrapeSweetwater()
    {
        $sections = array(
            'http://www.sweetwater.com/shop/studio'
        );

        $categories = array(
            'Recording',
            'Computer Audio'
        );

        foreach($sections as $section)
        {
            // get the HTML
            $html = file_get_contents($section);

            // Extract category URLs
            $categoryLinks = $this->extractCategories($html, $categories);

            // First Level
            foreach($categoryLinks as $category => $links)
            {
                $subCategories = array();

                // Second Level
                foreach($links as $subCategory => $link)
                {
                    $secondLevel = $this->extractSubCategories($link, $subCategory);

                    $itemLists = array();

                    // Loop through lists of all gear in category
                    foreach($secondLevel as $listCategory => $link)
                    {
                        $itemList = $this->getAllItemPages($link, $listCategory);

                        // loop through each individual item
                        foreach($itemList as $itemLink)
                        {
                            $this->addSweetwaterItem($this->_base_url . $itemLink);
                        }

                        $itemLists[$listCategory] = $itemList;
                        break;  // remove this for final run
                    }
                    
                    $subCategories[$subCategory] = $itemLists;
                    break;  // remove this for final run
                }

                $categoryLinks[$category] = $subCategories;
                break;  // remove this for final run
            }

            print_r($categoryLinks);
            exit;
            
//            var_dump($categoryLinks);
//            exit;
        }
    }

    public function extractCategories($html, $categories)
    {
        $categoryLinks = array();

        // extract ul with category links
        $ulPos = strpos($html, '<ul id="SWCatMenu">');

        if($ulPos !== false)
        {
            // trim extra html
            $html = substr($html, $ulPos);
            $endPos = strpos($html, '<!-- /#SWAccessories -->');
            $html = substr($html, 0, $endPos);

            foreach($categories as $category)
            {
                $categoryLinks[$category] = $this->extractCategory($html, $category);
            }

            return $categoryLinks;
        }
        else
            return false;
    }

    public function extractCategory($html, $category)
    {
        $links = array();

        $pos = strpos($html, 'class="SWCat">'.$category);
        $html = substr($html, $pos);

        $endPos = strpos($html, '<!-- .SWBrands -->');
        $html = substr($html, 0, $endPos);

        $start = 0;

        for($i=0; $i<20; $i++)
        {
            $pos = strpos($html, 'href="', $start);

            if($pos === false) {
                break;
            }

            $pos = $pos + 6;

            // get link
            $endPos = strpos($html, '"', $pos);
            $link = substr($html, $pos, $endPos - $pos);
            
            // extract sub cat name
            $pos = strrpos($link, "/");
            $subCategory = substr($link, $pos + 1);

            $links[$subCategory] = $link;

            $start = $endPos;
        }

        return $links;
    }

    public function extractSubCategories($link, $subCategory)
    {
        $links = array();
        
        $html = file_get_contents($this->_base_url . $link);

        // extract only HTML section with links
        $html = $this->extractHtmlBetween($html, "Featured Categories", "</table>");

        $start = 0;

        for($i=0; $i<20; $i++)
        {
            $pos = strpos($html, 'productstitle"><a href="', $start);

            if($pos === false) {
                break;
            }

            $pos = $pos + 24;

            // save link
            $endPos = strpos($html, '"', $pos);
            $link = substr($html, $pos, $endPos - $pos);

            // extract sub cat name
            $pos = strrpos($link, "/");
            $subCategory = substr($link, $pos + 1);

            $links[$subCategory] = $link;

            $start = $endPos;
        }
        
        return $links;
    }

    public function extractHtmlBetween($html, $startString, $endString)
    {
        $pos = strpos($html, $startString);
        $html = substr($html, $pos);

        $endPos = strpos($html, $endString);
        $html = substr($html, 0, $endPos);

        return $html;
    }
    
    public function getAllItemPages($link, $subCategory)
    {
        $links = array();

        $html = file_get_contents($this->_base_url . $link . "/popular/all");
        
        // extract only HTML section with links
        $html = $this->extractHtmlBetween($html, "productimage", "</table>");

        $start = 0;

        for($i=0; $i<100; $i++)
        {
            $pos = strpos($html, 'productimage" width="130"><a href="', $start);

            if($pos === false) {
                break;
            }

            $pos = $pos + 35;

            // save link
            $endPos = strpos($html, '"', $pos);
            $link = substr($html, $pos, $endPos - $pos);
            
            // remove extra slash
            $link = substr($link, 0, strlen($link) - 1);
            
            // extract sub cat name
            $pos = strrpos($link, "/");
            $subCategory = substr($link, $pos + 1);

            $links[$subCategory] = $link;

            $start = $endPos;
        }

        return $links;
    }

    public function addSweetwaterItem($link)
    {
        $html = file_get_contents($link);
//        echo $link;
        
        // Get item name
        $title = $this->extractHtmlBetween($html, "<title>", "</title>");
        $title = substr($title, 7);

        $pos = strpos($title, "|");
        $rawItemName = substr($title, 0, $pos - 1);

        // extract only HTML section with info
        $html = $this->extractHtmlBetween($html, "productheadline", "<!-- Demo Text -->");
//        var_dump($html);
//        exit;
        // Get company Name
        $pos = strpos($html, "store/manufacturer/");
        $pos = $pos + strlen("store/manufacturer/");
        $endPos = strpos($html, '"', $pos);
        $companyName = substr($html, $pos, $endPos - $pos);
        
        // Strip company name from item
        $itemName = trim(str_replace($companyName, '', $rawItemName));

        // check if item already exists
        $gear = GearPeer::getByName($itemName);

        if(!$gear)
        {
            $gear = new Gear();

             // add a tag for this new item if it doesn't exist
//            $tagName = myUtil::slugify($itemName);
//            $tag = myTag::getTagByName($tagName);
//
//            if(!$tag)
//            {
//                $tag = new Tag();
//                $tag->setName($tagName);
//                $tag->save();
//            }

            // Create company record if needed
            $company = GearCompanyPeer::getCompanyByName($companyName);

            if(!$company)
            {
                $company = new GearCompany();
                $company->setupNewCompany($companyName);
                $company->save();
            }

            $gear->setCompanyId($company->getId());

            // Create Category
            $category = new GearCategory();
            $categories = $this->parseBreadcrumbs($html);

            $primary = (isset($categories[0])) ? $categories[0] : '';
            $category->setPrimary($primary);

            $secondary = (isset($categories[1])) ? $categories[1] : '';
            $category->setSecondary($secondary);

            $sub1 = (isset($categories[2])) ? $categories[2] : '';
            $category->setSub1($sub1);

            $sub2 = (isset($categories[3])) ? $categories[3] : '';
            $category->setSub2($sub2);
            
            $category->save();

            $gear->setCategoryId($category->getId());


            // set Gear information
            $gear->setName($itemName);

//            $pos = strpos($html, '<!--END DETAILPAGE_LEFTSIDE-->');
//            $pos = strpos($html, '</span><br>', $pos);
//            $about = substr($html, $pos + 11, strlen($html));

            $tag_id = $gear->prepare();
            $gear->save();

            $gearTag = new GearTag();
            $gearTag->setGearId($gear->getId());
            $gearTag->setTagId($tag_id);
            $gearTag->save();

            // Create images
            $this->createItemImages($html, $gear->getId());
        }
        else
            return "Item $itemName already exists";
    }

    public function parseBreadcrumbs($html)
    {
        $categories = array();
        $html = $this->extractHtmlBetween($html, "cookietrail", "</div>");

        $start = 0;

        for($i=0; $i<5; $i++)
        {
            $pos = strpos($html, 'href="', $start);
            
            if($pos === false) {
                break;
            }

            $pos = strpos($html, '>', $pos + 6);
            $pos = $pos + 1;

            // save link
            $endPos = strpos($html, '<', $pos);
            $categories[] = html_entity_decode(substr($html, $pos, $endPos - $pos));

            $start = $endPos;
        }

        return $categories;
    }

    public function createItemImages($html, $id)
    {
        $savePath = sfConfig::get('app_gear_gear_images');
        
        $pos = strpos($html, '/images/items') + 18;     // find beginning of name
        $endPos = strpos($html, '.', $pos);
        $imageBase = substr($html, $pos, $endPos - $pos);
        
        // save a temp image to disc
        $img = imagecreatefromjpeg($this->_base_url . "/images/items/750/" . $imageBase . "-large.jpg");
        imagejpeg($img, sfConfig::get('sf_upload_dir').'/temp.jpg');

        $img = new sfImage(sfConfig::get('sf_upload_dir').'/temp.jpg', 'image/jpg');

        // save full-size image, no larger than 1024x768
        $img->setQuality(100);

        if($img->getHeight() > $img->getWidth())
        {
            if($img->getHeight() > 768)
            {
                $img->resize(null, 768);
            }
        }
        else
        {
            if($img->getWidth() > 1024)
            {
                $img->resize(1024, null);
            }
        }
        $img->saveAs('images/' . $savePath . '/' . $id . '-full.jpg', 'image/jpg');


        // save main image
        if($img->getHeight() <= 300 && $img->getWidth() <= 400)
        {
            // if image is smaller than min requirements, just save image as is
            $img->saveAs('images/' . $savePath . '/' . $id . '-400.jpg', 'image/jpg');
        }
        else
        {
            // resize to fit 400 width and 300 height
            if($img->getHeight() >= $img->getWidth()) {
                $img->resize(null, 300);
            } else {
                $img->resize(400, null);
            }
        }
        $img->saveAs('images/' . $savePath . '/' . $id . '-400.jpg', 'image/jpg');


        // save thumbnail image 100x100
        $img->thumbnail(100,100);
        $img->saveAs('images/' . $savePath . '/' . $id . '-100.gif', 'image/gif');
    }
}
?>