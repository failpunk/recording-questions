<?php

/**
 * gear actions.
 *
 * @package    recording
 * @subpackage gear
 * @author     Justin Vencel
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class gearActions extends sfActions
{
    /**
     * If not in this list of users, redirect to the homepage.
     * *** remove when done with dev ***
     */
    public function preExecute()
    {
        // store current URI incase we need to be redirected back to this page
        $request = $this->getRequest();
        if($request->getPathInfo() != '/getEbayResults')
        {
            $this->getUser()->setAttribute('lastPageUri', $request->getPathInfo());
        }
    }

    private function setMetaTags($title, $description)
    {
        $title = ucwords($title);
        $title .= " - " . ucFirst(sfConfig::get("app_domain_name"));

        $this->getResponse()->setTitle($title);
        $this->getResponse()->addMeta('description', ucfirst($description));
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->page    = $request->getParameter('page', 1);
        $this->results = $request->getParameter('results', 15);

        $this->setMetaTags('Recording Gear and Equipment', "Find recording gear for your studio, read reviews, add new gear, interact with other members.");
    }

    /**
     *   Page to display company categories
     */
    public function executeCategories(sfWebRequest $request)
    {
        $this->page     = $request->getParameter('page', 1);
        $this->results  = $request->getParameter('results', 15);
        $this->category = $request->getParameter('category_name', 'interface');

        $category_list = StudioCategories::getStudioArray();
        $this->nice_category = $category_list[$this->category];

        $this->setMetaTags("Browse $this->nice_category Gear Companies", "Browse through a complete listing of recording gear companies.");
    }

    public function executeScraper(sfWebRequest $request)
    {
        $items = array(
        'http://www.sweetwater.com/store/detail/FireBox/',
        'http://www.sweetwater.com/store/detail/Duet/',
        'http://www.sweetwater.com/store/detail/SaffPro24DSP/',
        'http://www.sweetwater.com/store/detail/8pre/',
        'http://www.sweetwater.com/store/detail/SaffPro24/',
        'http://www.sweetwater.com/store/detail/828mk3/',
        'http://www.sweetwater.com/store/detail/Ensemble/',
        'http://www.sweetwater.com/store/detail/FireStuMobile/',
        'http://www.sweetwater.com/store/detail/SaffireLQ56/',
        'http://www.sweetwater.com/store/detail/ProFire2626/',
        'http://www.sweetwater.com/store/detail/896mk3/',
        'http://www.sweetwater.com/store/detail/FireStuProj/',
        'http://www.sweetwater.com/store/detail/Fireface800/',
        'http://www.sweetwater.com/store/detail/FirewireSolo/',
        'http://www.sweetwater.com/store/detail/TubeFire8/',
        'http://www.sweetwater.com/store/detail/TravelerMk3/',
        'http://www.sweetwater.com/store/detail/Onyx820i/',
        'http://www.sweetwater.com/store/detail/Fireface400/',
        'http://www.sweetwater.com/store/detail/ProFireLB/',
        'http://www.sweetwater.com/store/detail/FireStuTube/',
        'http://www.sweetwater.com/store/detail/Konnekt24D/',
        'http://www.sweetwater.com/store/detail/MR816CSX/',
        'http://www.sweetwater.com/store/detail/FireStuLP/',
        'http://www.sweetwater.com/store/detail/MR816X/',
        'http://www.sweetwater.com/store/detail/SaffireLE/',
        'http://www.sweetwater.com/store/detail/V4HD/',
        'http://www.sweetwater.com/store/detail/Inspire1394/',
        'http://www.sweetwater.com/store/detail/FW810S/',
        'http://www.sweetwater.com/store/detail/Aurora8FW/',
        'http://www.sweetwater.com/store/detail/SC48/',
        'http://www.sweetwater.com/store/detail/FaderPort/',
        'http://www.sweetwater.com/store/detail/MCmix/',
        'http://www.sweetwater.com/store/detail/MCcontrol/',
        'http://www.sweetwater.com/store/detail/AlphaTrack/',
        'http://www.sweetwater.com/store/detail/SLmk2zero/',
        'http://www.sweetwater.com/store/detail/CC121/',
        'http://www.sweetwater.com/store/detail/UC33e/',
        'http://www.sweetwater.com/store/detail/Xone2D/',
        'http://www.sweetwater.com/store/detail/MCSPanner/',
        'http://www.sweetwater.com/store/detail/MC/',
        'http://www.sweetwater.com/store/detail/OmniControl/',
        'http://www.sweetwater.com/store/detail/MCUpro/',
        'http://www.sweetwater.com/store/detail/MCUproXT/',
        'http://www.sweetwater.com/store/detail/Launchpad/',
        'http://www.sweetwater.com/store/detail/MidiExp128/',
        'http://www.sweetwater.com/store/detail/FastTrackPro/',
        'http://www.sweetwater.com/store/detail/UM3G/',
        'http://www.sweetwater.com/store/detail/FastLane/',
        'http://www.sweetwater.com/store/detail/Wedgies/',
        'http://www.sweetwater.com/store/detail/CornerFill2Bu/',
        'http://www.sweetwater.com/store/detail/SFlat1114BUR/',
        'http://www.sweetwater.com/store/detail/FlexiBoothG/',
        'http://www.sweetwater.com/store/detail/Reflexion/',
        'http://www.sweetwater.com/store/detail/TFusorSingle/',
        'http://www.sweetwater.com/store/detail/MetroDiff/',
        'http://www.sweetwater.com/store/detail/MiniFusor/',
        'http://www.sweetwater.com/store/detail/LENRD8CHA/',
        'http://www.sweetwater.com/store/detail/Atom12BLU/',
        'http://www.sweetwater.com/store/detail/VenusBass/',
        'http://www.sweetwater.com/store/detail/MoPAD/',
        'http://www.sweetwater.com/store/detail/GRAMMA/',
        'http://www.sweetwater.com/store/detail/RX7f/',
        'http://www.sweetwater.com/store/detail/FlexiBoothB/',
        'http://www.sweetwater.com/store/detail/PlatFoam/',
        'http://www.sweetwater.com/store/detail/Live8/',
        'http://www.sweetwater.com/store/detail/APC40/',
        'http://www.sweetwater.com/store/detail/MPD18/',
        'http://www.sweetwater.com/store/detail/EWIusb/',
        'http://www.sweetwater.com/store/detail/MPC500/',
        'http://www.sweetwater.com/store/detail/MPC1000/',
        'http://www.sweetwater.com/store/detail/MPC2500/'
        );
        $scraper = new Scraper();

        foreach($items as $link)
        {
            $scraper->addSweetwaterItem($link);
        }
    }

    public function executeCompany(sfWebRequest $request)
    {
        $company_name = $request->getParameter('company_name', false);
        $meta_description = '';

        if($company_name)
        {
            $company = GearCompanyPeer::getCompanyByName(myUtil::unslugify($company_name));

            if($company)
            {
                $this->company = $company;
                $company_info = GearCompanyInfoPeer::getLatestRevision($company->getId());

                if($company_info)
                {
                    $this->company_info = $company_info;
                    $this->revision_user = UserPeer::retrieveByPK($company_info->getUserId());

                    $meta_description = substr($company_info->getAbout(), 0, 150);
                }
                else
                    $this->company_info = false;
            }
            else
            {
                $this->forward('gear', 'index');
            }
        }
        else
            $this->redirect404();

        $meta_description = ($meta_description == '') ? $company->getName() . ' company profile page' : $meta_description;
        $this->setMetaTags($company->getName(), $meta_description);
    }

    public function executeCompanyGear(sfWebRequest $request)
    {
        $company_name   = myUtil::unslugify($request->getParameter('company_name', false));
        $this->page     = $request->getParameter('page', 1);
        $this->results  = $request->getParameter('results', 15);

        if($company_name)
        {
            $company = GearCompanyPeer::getCompanyByName($company_name);

            if($company)
            {
                $this->company = $company;
            }
            else
            {
                $this->forward('gear', 'index');
            }
        }
        else
            $this->redirect404();
    }

    public function executeCompanies(sfWebRequest $request)
    {
        $this->setMetaTags('recording gear companies', 'Discover the latest recording gear companies to be added to our interactive database.');
    }

    public function executeGearDetail(sfWebRequest $request)
    {
        $company_name   = $request->getParameter('company_name', false);
        $gear_name      = $request->getParameter('gear_name', false);
        $gear_id        = $request->getParameter('gear_id', false);

        $this->show_review = $request->getParameter('reviews', false);

        $this->added_to_studio = false;
        $this->ownership = false;
        $this->revision_user = false;
        $gear_description = false;

        if($company_name && $gear_name && $gear_id)
        {
            $gear = GearPeer::retrieveByPK($gear_id);

            if($gear)
            {
                $this->gear = $gear;
                $this->company = $gear->getGearCompany();

                // Get the latest edit revision
                $gear_info = $gear->getGearInfo();

                if($gear_info)
                {
                    $this->gear_info = $gear_info;
                    $this->revision_user = UserPeer::retrieveByPK($gear_info->getUserId());
                    $gear_description = substr($gear_info->getAbout(), 0, 250);
                }
                else
                    $this->gear_info = false;

                // if user is logged in, see if they have added this gear to their studio
                if($this->getUser()->isAuthenticated())
                {
                    $user_id = $this->getUser()->getCurrentUser()->getId();
                    $user_gear = UserGearPeer::retrieveByPK($user_id, $gear_id);

                    if($user_gear && !$user_gear->getUserHad())
                    {
                        $this->added_to_studio = true;
                        $this->ownership = $user_gear->getOwnershipText();
                    }
                }

                $gear_name = $this->company->getName() . ' ' . $gear->getName();
                if(!$gear_description)
                    $gear_description = "Read information, reviews, disscus, and buy the $gear_name";
                $this->setMetaTags($gear_name, $gear_description);
            }
            else
                $this->forward404("Could not find the gear named $gear_name");
        }
        else
            $this->forward404();
    }

    /**
     * Add a piece of gear to a users studio list
     */
    public function executeAddToStudio(sfWebRequest $request)
    {
        $gear_id    = $request->getParameter('gear_id', false);
        $ownership  = $request->getParameter('ownership', false);
        $execute    = $request->getParameter('execute', false);

        $result = array(
            'execute' => $execute,
            'status' => false
        );

        if($this->getUser()->isAuthenticated() && $gear_id && $ownership && $execute)
        {
            $gear = GearPeer::retrieveByPK($gear_id);

            if($gear)
            {
                $user_id = $this->getUser()->getCurrentUser()->getId();

                // check for existing gear
                if($execute == "remove")
                {
                    $result['status'] = UserGear::removeFromStudio($user_id, $gear_id);
//                    $gear->sendTweet($user_id, 'removeStudio');
                }
                else
                {
                    if(UserGear::addToStudio($user_id, $gear_id, $ownership))
                    {
                        $result['status'] = $ownership;

                        if($ownership == "You Own This")
                            $gear->sendTweet($user_id, 'addStudio');
//                        else
//                            $gear->sendTweet($user_id, 'wantStudio');
                    }
                    else
                    {
                        $result['status'] = false;
                    }
                }
            }
            else
                die("Gear not found");
        }

        echo json_encode($result);
        exit;
    }

    public function executeAutocompleteSearch(sfWebRequest $request)
    {
        $search_text = trim($this->getRequest()->getParameter('q'));

        $search_array = explode(' ', $search_text);

        $gears      = GearPeer::findLike($search_array, 30);
        $companies  = GearCompanyPeer::findLike($search_array, 30);

        $results = array();

        if($gears)
        {
            foreach($gears as $gear)
            {
                $result = array();
                $result['type'] = 'gear';
                $result['id'] = $gear[0];
                $result['name'] = $gear[1];
                $result['company'] = $gear[2];

                $results[] = $result;
            }
        }

        if($companies)
        {
            foreach($companies as $companies)
            {
                $result = array();
                $result['type'] = 'company';
                $result['id'] = $companies[0];
                $result['name'] = $companies[1];
                $result['company'] = '';

                $results[] = $result;
            }
        }

        $this->results = $results;
    }

    public function executeAddSiteReview(sfWebRequest $request)
    {
        $url        = $request->getParameter('url');
        $date       = $request->getParameter('date');
        $summary    = $request->getParameter('summary');
        $gear_id    = $request->getParameter('gearid');
        $title      = $request->getParameter('title');

        if($url && $date && $summary && $gear_id && $title)
        {
            if($this->getUser()->isAuthenticated())
            {
                $user_id = $this->getUser()->getCurrentUser()->getId();

                $formatted_date = date('m/d/Y', strtotime($date));

                $gear_review = new GearReview();
                $gear_review->addNewSiteReview($gear_id, $user_id, $url, $title, $summary, $formatted_date);

                // Send a tweet for the user
                $gear = GearPeer::retrieveByPK($gear_id);
                if($gear)
                {
                    $gear->sendTweet($user_id, 'siteReview');
                }

                $this->review = $gear_review;
            }
        }
    }

    public function executeAddUserReview(sfWebRequest $request)
    {
        $title      = $this->getRequest()->getParameter('title');
        $summary    = $this->getRequest()->getParameter('summary');
        $review     = $this->getRequest()->getParameter('review');
        $gear_id    = $this->getRequest()->getParameter('gearid');

        if($summary && $gear_id && $title && $review)
        {
            if($this->getUser()->isAuthenticated())
            {
                $user_id = $this->getUser()->getCurrentUser()->getId();

                $gear_review = new GearReview();
                $gear_review->addNewUserReview($gear_id, $user_id, $title, $summary, $review);

                $this->review = $gear_review;
            }
        }
    }

    public function executeAddOffensiveVote(sfWebRequest $request)
    {
        $post_id = $this->getRequest()->getParameter('postid');
        $type    = $this->getRequest()->getParameter('type');

        if($post_id && $this->getUser()->isAuthenticated())
        {
            $user_id = $this->getUser()->getCurrentUser()->getId();

            $flag = OffensivePeer::findPreviousVote($type, $post_id, $user_id);

            if($flag == 0)
            {
                $offensive = new Offensive();
                $offensive->setUserId($user_id);
                $offensive->setKey($post_id);
                $offensive->setType($type);
                $save = $offensive->save();
                if($save === true)
                {
                    $result = array('status' => true);
                } else
                {
                    $result = array('status' => false, 'message' => $save);
                }
            }
            else
                $result = array('status' => false, 'message' => 'You have already flagged this as offensive.');

            echo json_encode($result);
        }
        exit;
    }

    /**
     *  Used to 301 redirect to the proper gear URL from tags
     */
    public function executeLinkGear(sfWebRequest $request)
    {
        $gear_id = $this->getRequest()->getParameter('gear_id');

        if($gear_id)
        {
            $gear = GearPeer::retrieveByPK($gear_id);

            if($gear)
            {
                $this->redirect($gear->getRoute(), 301);
            }
            else
                $this->forward404();
        }
        else
            $this->forward404();
    }

    /**
     *  Used to 301 redirect to the proper company URL from tags
     */
    public function executeLinkCompany(sfWebRequest $request)
    {
        $company_id = $this->getRequest()->getParameter('company_id');

        if($company_id)
        {
            $company = GearCompanyPeer::retrieveByPK($company_id);

            if($company)
            {
                $this->redirect($company->getRoute(), 301);
            }
            else
                $this->forward404();
        }
        else
            $this->forward404();
    }

    public function executeAddNew(sfWebRequest $request)
    {
        if($this->getUser()->isAuthenticated())
        {
            $this->add_type = ucfirst($request->getParameter('add_type'));

            $this->display_gear     = 'display:none;';
            $this->display_company  = 'display:none;';

            if($this->add_type == 'Gear')
            {
                $this->display_gear = 'display:block;';
            }

            if($this->add_type == 'Company')
            {
                $this->display_company = 'display:block;';
            }
        }
        else
            $this->redirect('@login');
    }

    public function executeGearAddToDb(sfWebRequest $request)
    {
        $gear_name      = $request->getParameter('gear');
        $company_name   = $request->getParameter('company');
        $about          = $request->getParameter('about-gear');
        $section        = $request->getParameter('gear-type');
        $image_name     = $request->getParameter('upload-image-file-name');

        if($this->getUser()->isAuthenticated())
        {
            $company = GearCompanyPeer::getCompanyByName($company_name);

            if(!$company)
            {
                $company = new GearCompany();
                $company->setupNewCompany($company_name);
            }

            $user_id = $this->getUser()->getCurrentUser()->getId();

            $gear = new Gear();
            $gear->setName($gear_name);
            $gear->setSearchName(myUtil::unslugify($gear_name));
            $gear->setCategoryId(1);
            $gear->setCompanyId($company->getId());
            $gear->setSection($section);

            // save about data to gear_info table
            $gear_info = new GearInfo();
            $gear_info->setUserId($user_id);
            $gear_info->setAbout(myUtil::cleanText($about));

            $gear_info->setIp(myUtil::getUserIp($request));

            $gear->addGearInfo($gear_info);

            // Ensure the other things are prepared to add new gear
            $tag_id = $gear->prepare();

            $gear->save();

            $gearTag = new GearTag();
            $gearTag->setGearId($gear->getId());
            $gearTag->setTagId($tag_id);
            $gearTag->save();

            $gear->createImages($image_name);

            // add to recent activity
            RecentActivity::addActivity($user_id, 'created', array('GearId' => $gear->getId()));

            $this->redirect($gear->getRoute());
        }
        else
            $this->redirect('@login');
    }

    /**
     *  Upload a new image for a piece of gear
     */
    public function executeUpdateImage(sfWebRequest $request)
    {
        $this->image_for = $request->getParameter('for', '');
        $this->id        = $request->getParameter('id');
        $this->type      = $request->getParameter('type');

        if($this->id && $this->getUser()->isAuthenticated())
        {
            if($request->isMethod('post'))
            {
                $image_name = $request->getParameter('upload-image-file-name');
                $user_id = $this->getUser()->getCurrentUser()->getId();

                if($this->type == 'gear')
                {
                    $gear = GearPeer::retrieveByPK($this->id);
                    $gear->createImages($image_name);
                    $route = $gear->getRoute();

                    RecentActivity::addActivity($user_id, 'updated the image for', array('GearId' => $this->id));
                }
                else
                {
                    $company = GearCompanyPeer::retrieveByPK($this->id);
                    $company->createImages($image_name);
                    $route = $company->getRoute();

                    RecentActivity::addActivity($user_id, 'updated the image for', array('CompanyId' => $this->id));
                }

                $this->redirect($route);
            }
        }
        else
            $this->redirect('@login');
    }

    public function executeCompanyAddToDb(sfWebRequest $request)
    {
        $company_name   = $request->getParameter('company');
        $about          = $request->getParameter('about-company');
        $website        = $request->getParameter('website');
        $image_name     = $request->getParameter('upload-image-file-name');

        if($this->getUser()->isAuthenticated())
        {
            $company = GearCompanyPeer::getCompanyByName($company_name);

            if(!$company)
            {
                $company = new GearCompany();
                $company->setupNewCompany($company_name);
                $company->createImages($image_name);


                $user_id = $this->getUser()->getCurrentUser()->getId();

                // save about data to gear_info table
                $company_info = new GearCompanyInfo();
                $company_info->setUserId($user_id);
                $company_info->setAbout(myUtil::cleanText($about));
                $company_info->setWebsite($website);

                $company_info->setIp(myUtil::getUserIp($request));

                $company->addGearCompanyInfo($company_info);

                $company->save();
            }

            $this->redirect($company->getRoute());
        }
        else
            $this->redirect('@login');
    }

    public function executeAutocompleteCompany(sfWebRequest $request)
    {
        $search_text = $this->getRequest()->getParameter('q');
        $search_array = explode(' ', $search_text);

        $this->companies = GearCompanyPeer::findLike($search_array, 30);
    }

    public function executeAutocompleteGear(sfWebRequest $request)
    {
        $search_text = $this->getRequest()->getParameter('q');
        $search_array = explode(' ', $search_text);

        $this->gears = GearPeer::findLike($search_array, 30);

    }

    public function executeUploadImage(sfWebRequest $request)
    {
        $image_url = $this->getRequest()->getParameter('image_url');

        if($image_url)
        {
            $info = @GetImageSize($image_url);
            $mime = $info['mime'];

            $size = (($info[0] * $info[1]) / $info['bits']) / 1024;

            if($size > 2000)
            {
                echo json_encode(array('status' => false, 'message' => 'Image is too large, it must be less than 2MB'));
                exit;
            }

            // What sort of image?
            $type = substr(strrchr($mime, '/'), 1);

            switch ($type)
            {
                case 'jpeg':
                    $image_create_func = 'ImageCreateFromJPEG';
                    $new_image_ext = 'jpg';
                    break;

                case 'png':
                    $image_create_func = 'ImageCreateFromPNG';
                    $new_image_ext = 'png';
                    break;

                case 'bmp':
                    $image_create_func = 'ImageCreateFromBMP';
                    $new_image_ext = false;
                    break;

                case 'gif':
                    $image_create_func = 'ImageCreateFromGIF';
                    $new_image_ext = 'gif';
                    break;

                case 'vnd.wap.wbmp':
                    $image_create_func = 'ImageCreateFromWBMP';
                    $new_image_ext = false;
                    break;

                case 'xbm':
                    $image_create_func = 'ImageCreateFromXBM';
                    $new_image_ext = false;
                    break;

                default:
                    $image_create_func = 'ImageCreateFromJPEG';
                    $new_image_ext = 'jpg';
            }

            if($new_image_ext)
            {
                $hash = md5($image_url);
                $img = $image_create_func($image_url);
                $file_name = $hash.'.'.$new_image_ext;
                imagejpeg($img, sfConfig::get('sf_upload_dir') . '/' . $file_name);
            }

            echo json_encode(array('status' => true, 'name' => $file_name));
        }
        exit;
    }

    public function executeUpdateAbout(sfWebRequest $request)
    {
        $this->id   = $this->getRequest()->getParameter('gearid');
        $this->text = trim($this->getRequest()->getParameter('abouttext'));

        if($this->id && $this->text)
        {
            $gear_info = GearInfoPeer::getLatestRevision($this->id);
            $new_info = new GearInfo();
            $current_text = "";

            // carry-over existing specs text
            if($gear_info)
            {
                $new_info->setSpecs($gear_info->getSpecs());
                $current_text = $gear_info->getAbout();
            }

            $user_id = $this->getUser()->getCurrentUser()->getId();

            $this->text = myUtil::cleanText($this->text);

            // check if user changed the about text
            if($this->text != $current_text)
            {
                $new_info->setGearId($this->id);
                $new_info->setUserId($user_id);
                $new_info->setIp(myUtil::getUserIp($request));
                $new_info->setAbout($this->text);
                $new_info->save();

                RecentActivity::addActivity($user_id, 'updated', array('GearId' => $new_info->getGearId()));
            }
            echo json_encode(array('status' => true));
        }
        else
            echo json_encode(array('status' => false, 'message'=> 'The about section can not be left blank'));

        exit;
    }

    public function executeUpdateSpecs(sfWebRequest $request)
    {
        $this->id   = $this->getRequest()->getParameter('gearid');
        $text = trim($this->getRequest()->getParameter('specstext'));

        if($this->id && $text)
        {
            $gear_info = GearInfoPeer::getLatestRevision($this->id);
            $new_info = new GearInfo();
            $current_text = "";

            // carry-over existing about text
            if($gear_info)
            {
                $new_info->setAbout($gear_info->getAbout());
                $current_text = $gear_info->getSpecs();
            }

            $user_id = $this->getUser()->getCurrentUser()->getId();
            $text = htmlentities($text);
            $text = myUtil::cleanText($text);

            // check if user changed the specs text
            if($text != $current_text)
            {
                $new_info->setGearId($this->id);
                $new_info->setUserId($user_id);
                $new_info->setIp(myUtil::getUserIp($request));
                $new_info->setSpecs($text);
                $new_info->save();

                RecentActivity::addActivity($user_id, 'updated', array('GearId' => $new_info->getGearId()));
            }
            echo json_encode(array('status' => true));
        }
        else
            echo json_encode(array('status' => false, 'message'=> 'The specs section can not be left blank'));

        exit;
    }


    public function executeUpdateCompanyAbout(sfWebRequest $request)
    {
        $company_id = $this->getRequest()->getParameter('companyid');
        $url        = trim($this->getRequest()->getParameter('url'));
        $about      = trim($this->getRequest()->getParameter('abouttext'));

        if($company_id && $about)
        {
            $company_info = GearCompanyInfoPeer::getLatestRevision($company_id);
            $new_info = new GearCompanyInfo();

            // carry-over latest
            if($company_info)
            {
                $new_info->setAbout($company_info->getAbout());
                $new_info->setWebsite($company_info->getWebsite());
            }

            $user_id = $this->getUser()->getCurrentUser()->getId();

            $about = myUtil::cleanText($about);

            // check if user changed the about text
            if($new_info->getAbout() != $about || $new_info->getWebsite() != $url)
            {
                $new_info->setCompanyId($company_id);
                $new_info->setUserId($user_id);
                $new_info->setIp(myUtil::getUserIp($request));
                $new_info->setAbout($about);
                $new_info->setWebsite($url);
                $new_info->save();

                RecentActivity::addActivity($user_id, 'updated', array('CompanyId' => $new_info->getCompanyId()));
            }
            echo json_encode(array('status' => true));
        }
        else
            echo json_encode(array('status' => false, 'message'=> 'The about section can not be left blank'));

        exit;
    }

    /**
     *  Flag a page
     */
    public function executeFlagPage(sfWebRequest $request)
    {
        $reason = trim($this->getRequest()->getParameter('reason'));
        $id     = trim($this->getRequest()->getParameter('id'));
        $type   = trim($this->getRequest()->getParameter('type'));

        if($reason && $id && $type)
        {
            if($type == 'gear')
                $data = GearPeer::retrieveByPK($id);
            else
                $data = GearCompanyPeer::retrieveByPK($id);

            if($data)
            {
                $user_id = $this->getUser()->getCurrentUser()->getId();

                // check for existing votes
                $flag = OffensivePeer::findPreviousVote($type, $id, $user_id);

                if($flag == 0)
                {
                    $flag = new Offensive();
                    $save = $flag->flagPage($type, $id, $user_id, $reason);

                    if($save === true)
                    {
                        $result = array('status' => true, 'message' => 'Thanks for keeping an eye on the community!');
                    } else
                    {
                        $result = array('status' => false, 'message' => $save);
                    }
                }
                else
                    $result = array('status' => false, 'message' => 'You have already flagged this.');

                echo json_encode($result);
            }
        }
        exit;
    }

    public function executeRecentActivity(sfWebRequest $request)
    {
        $page    = $request->getParameter('page', 1);
        $results = $request->getParameter('results', 15);

        $this->recent_activity = RecentActivityPeer::getActivity($page, $results);
    }

    public function executeDeleteCompany(sfWebRequest $request)
    {
        $company_id = $request->getParameter('company_id', 1);

        if($this->getUser()->isAuthenticated())
        {
            if($this->getUser()->getCurrentUser()->getId() == 4 || $this->getUser()->getCurrentUser()->getId() == 2)
            {
                $company = GearCompanyPeer::retrieveByPK($company_id);
                $company->delete();
            }
        }

        $this->redirect('@gear');
    }


    public function executeLargeGearImage(sfWebRequest $request)
    {
        $image_name = $request->getParameter('image_name', 1);

        echo '<img src="/images/'.$image_name.'"/>';
        exit;
    }

    public function executeGetFullUserReview(sfWebRequest $request)
    {
        $review_id = $request->getParameter('review_id', false);

        if($review_id)
        {
            $review = GearReviewPeer::retrieveByPK($review_id);

            if($review)
            {
                $this->review = $review;
            }
        }
    }

    /**
     *  Call this via AJAX to load ebay results
     */
    public function executeLoadEbayResults(sfWebRequest $request)
    {
        $gear_name = $request->getParameter('gear_name', '');

        return $this->renderComponent('gear', 'ebayListings', array('gear_name' => $gear_name));
        exit;
    }

    public function executeUserReviewDetail(sfWebRequest $request)
    {
        $company_name   = $request->getParameter('company_name', false);
        $gear_name      = $request->getParameter('gear_name', false);
        $gear_id        = $request->getParameter('gear_id', false);
        $review_id      = $request->getParameter('review_id', false);

        if($company_name && $gear_name && $gear_id)
        {
            $gear = GearPeer::retrieveByPK($gear_id);

            if($gear)
            {
                $this->gear = $gear;
                $this->company = $gear->getGearCompany();

                // Get the latest edit revision
                $gear_info = $gear->getGearInfo();

                if($gear_info)
                {
                    $this->gear_info = $gear_info;
                    $this->revision_user = UserPeer::retrieveByPK($gear_info->getUserId());
                }
                else
                    $this->gear_info = false;

                // if user is logged in, see if they have added this gear to their studio
                if($this->getUser()->isAuthenticated())
                {
                    $user_id = $this->getUser()->getCurrentUser()->getId();
                    $user_gear = UserGearPeer::retrieveByPK($user_id, $gear_id);

                    if($user_gear && !$user_gear->getUserHad())
                    {
                        $this->added_to_studio = true;
                        $this->ownership = $user_gear->getOwnershipText();
                    } else
                    {
                        $this->added_to_studio = false;
                    }
                }

                $gear_name = $this->company->getName() . ' ' . $gear->getName();
                $this->setMetaTags($gear_name, "Read information, reviews, disscus, and buy the $gear_name");

                // get gear review
                $this->user_review = GearReviewPeer::retrieveByPK($review_id);
                $this->user = UserPeer::retrieveByPK($this->user_review->getUserId());
            }
            else
                $this->forward404("Could not find the gear named $gear_name");
        }
        else
            $this->forward404();
    }

    public function executeUpdateUserPlatform(sfWebRequest $request)
    {
        $platform = $request->getParameter('platform', false);
        $result = json_encode(array('status' => false));

        if($platform)
        {
            $user_id = $this->getUser()->getCurrentUser()->getId();

            $user = UserPeer::retrieveByPK($user_id);

            if($user)
            {
                $user->setPlatform($platform);
                $user->save();
                $result = json_encode(array('status' => true));
            }
        }

        echo $result;
        exit;
    }

    public function executeRssForGear(sfWebRequest $request)
    {
        $gear = GearPeer::getNewestForRss(50);

        if($gear)
        {
            $feed = Gear::createRss($gear);
        }
        else
            $feed = false;

        $this->feed = $feed;
    }

    public function executeAffiliateRedirect(sfWebRequest $request)
    {
        $description = $request->getParameter('description', false);
        $id = $request->getParameter('id', false);

        if($description && $id)
        {
            $gear = GearPeer::retrieveByPK($id);

            if($gear)
            {
                $affiliate_link = $gear->getAffiliateLink();

                AffiliateClick::recordClick($this->getUser()->getCurrentUser()->getId(), $affiliate_link['sku'], $gear->getId());

                if(array_key_exists('buy_url', $affiliate_link)) {
                    $this->redirect($affiliate_link['buy_url']);
                } else {
                    $this->redirect('@gear');
                }
            }
        }
        else
            $this->redirect404();
    }

    public function executeToggleGearAffiliate(sfWebRequest $request)
    {
        $redirect = $request->getParameter('redirect', false);

        $user = $this->getUser();

        if($redirect && $user->isAuthenticated() && $user->hasCredential('admin'))
        {
            if($user->getAttribute('show_affiliate', false))
                $user->setAttribute('show_affiliate', false);
            else
                $user->setAttribute('show_affiliate', true);

            $this->redirect($redirect);
        }
        else
            $this->redirect404();
    }
}