<?php

/**
 * index actions.
 *
 * @package    recording
 * @subpackage index
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class indexActions extends sfActions
{
    static $currentPage = 1;
    static $maxResultsPerPage = 15;

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->nav = $request->getParameter("nav");
        $this->initPagenation();

        $this->questions = $this->getQuestionFromNav($this->nav);

//		$countAnswers = QuestionPeer::getCountAnswers(self::$currentPage, self::$maxResultsPerPage);
//		$this->countAnswers = $countAnswers->getResults();

        $this->numbIndice = $this->getNumbIndice($this->questions->getNbResults());

        $this->getResponse()->setSlot('home_page', 'yes');
    }

    public function executeCj(sfWebRequest $request)
    {
        $cj = new CJ();
//        $cj->soapProviders();
//        $cj->soapLinks();
//        $cj->restSearch();
        $cj->importMusiciansFriendData();
    }

    public function executeAbout(sfWebRequest $request)
    {

    }

    public function executeFaq(sfWebRequest $request)
    {

    }

    public function executePrivacy(sfWebRequest $request)
    {

    }

    public function executeSearch(sfWebRequest $request)
    {
        $search = $request->getParameter('search');
        $this->nav = $request->getParameter("nav");
        $this->page = $request->getParameter('page', 1);

        $rss = $request->getParameter('rss');

        $this->getResponse()->setSlot('home_page', 'yes');

        // @TODO fix it

        if($this->nav == "relevance" || $this->nav == null)
            $retriveObj = 'retrieveByPKsExtended';
        if($this->nav == "newest")
            $retriveObj = 'retrieveByPKsExtendedByNewest';
        if($this->nav == "most_votes")
            $retriveObj = 'retrieveByPKsExtendedByMostVotes';
        if($this->nav == "most_active")
            $retriveObj = 'retrieveByPKsExtendedByMostActive';


        $this->initPagenation();

        $defaultOptions = array(
            'weights' => array(1000, 1),
            'sort'    => sfSphinxClient::SPH_SORT_EXTENDED,
            'sortby'  => '@weight DESC',
            'mode' => sfSphinxClient::SPH_MATCH_EXTENDED
        );

        $options = array_merge($defaultOptions, sfConfig::get('app_sphinx_related_question', array()));

        if (!empty($search))
        {

            // save search phrase to a file
            $f = fopen(sfConfig::get('app_search_location') . '/search.txt', 'a');
            fwrite($f, $search . "\n");
            fclose($f);

            $sphinx = new fpSphinxClient($options);

            $search = preg_replace('/\s+/', ' | ', $search);
            $res = $sphinx->search('@* ' . $search, 'question');

            $this->pager = new fpSphinxPager('Question', self::$maxResultsPerPage, $sphinx);
            $this->pager->setPage($this->page);
            $this->pager->setPeerMethod($retriveObj);
            $this->pager->init();

            $this->search = $search;

            if($rss)
            {
                if($this->nav == 'relevance' || $this->nav == null)
                {
                    $result = $this->pager->getResults();
                }
                else
                    $result = $this->pager->getResults(false);

                if($this->nav == "")
                    $this->nav = "relevance";

                foreach ($result as $question)
                {
                    $QuestionId[] = $question->getId();
                }
                $this->redirect("index/rssForQuestionList?nav=".$this->nav."&page=".$this->page."&results=".implode("-", $QuestionId));
            }


            $this->maxResultsPerPage = self::$maxResultsPerPage;

            $this->numbIndice = $this->getNumbIndice($this->pager->getNbResults());
        }
    }

    public function executeRssForQuestionList(sfWebRequest $request)
    {
        $nav = $request->getParameter("nav");
        $results = $request->getParameter("results");
        $page = $request->getParameter('page');

        self::$maxResultsPerPage = sfConfig::get('app_rss_conf_per_page');


        if($results)
        {
            $questionId = explode("-", $results);
            $questions = QuestionPeer::getByIdPKs($questionId, $page, self::$maxResultsPerPage);
        }
        else
            $questions = $this->getQuestionFromNav($nav);

        $feed = new sfRssFeed();
        $feed->initialize(
            array(
                'title'       => $this->getRssTitleFromNav($nav),
                'link'        => 'http://'.$request->getHost().'/index/'.$nav.'/',
                'authorEmail' => sfConfig::get('app_rss_conf_author_email'),
                'authorName'  => sfConfig::get('app_rss_conf_author_name')
            ));

        foreach ($questions->getResults() as $question)
        {
            $item = new sfFeedItem();
            $item->setTitle($question->getTitle());
            $item->setLink("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId());
            $item->setAuthorName($question->getUser()->getDisplayName());
            $item->setPubdate(strtotime($question->getCreatedAt()));
            $item->setDescription($question->getDescription());

            $feed->addItem($item);
        }
        $this->feed = $feed;
    }

    private function getRssTitleFromNav($nav)
    {
        switch (strtolower($nav))
        {
            case "recent":
                return "Recent Recording Questions";
                break;
            case "popular":
                return "Popular Recording Questions";
                break;
            case "lastweek":
                return "Last Weeks Recording Questions";
                break;
            case "lastmonth":
                return "Last Months Recording Questions";
                break;
            case "unanswered":
                return "Unanswered Recording Questions";
                break;
            default:
                return sfConfig::get('app_rss_conf_per_title');
        }
    }

    public function executeSearchByTag(sfWebRequest $request)
    {
        $tag = $request->getParameter('tag');
        $this->nav = $request->getParameter("nav");

        $this->getResponse()->setSlot('home_page', 'yes');

        $this->initPagenation();

        $modelId = myTag::getObjIdByTagName($tag);

        $this->questions = QuestionPeer::getByIdPKs($modelId, self::$currentPage, self::$maxResultsPerPage);

        $this->numbIndice = $this->getNumbIndice($this->questions->getNbResults());

        $this->tag = $tag;

        $this->setMetaTags("Questions tagged as $tag", "Use this page to find a list of questions that have been tagged by the asker as related to $tag");
    }

    public function executeError404(sfWebRequest $request)
    {
    }

    public function executeSendTweet(sfWebRequest $request)
    {
        $type = $request->getParameter('type',  false);
        $key  = $request->getParameter('key',  false);

        if($type && $key && $this->getUser()->isAuthenticated())
        {
            sfProjectConfiguration::getActive()->loadHelpers("Url");
            
            $twitter = new TwitterUser($this->getUser()->getCurrentUser()->getId());
            
            if($type == 'question')
            {
                $question = QuestionPeer::retrieveByPK($key);
            }

            $result = $twitter->sendTweet($question->createQuestionTweet());

            echo json_encode(array('result' => $result));
            exit;
        }
        else
            $this->redirect404();
    }

    private function getQuestionFromNav($nav)
    {
        if(empty($nav))
            $nav = "recent";

        $methodName = 'get'.ucfirst($nav).'Question';

        $ref = new ReflectionClass('QuestionPeer');

        if($ref->hasMethod($methodName))
        {
            return QuestionPeer::$methodName(self::$currentPage, self::$maxResultsPerPage);

        }
        else
        {
            $this->redirect404();
        }
    }

    private function initPagenation()
    {
        $currentPage = $this->getRequest()->getParameter('page');
        $maxResultsPerPage = $this->getRequest()->getParameter('results');

        if($currentPage)
            $this->currentPage = self::$currentPage = $currentPage;
        else
            $this->currentPage = self::$currentPage;

        if($maxResultsPerPage)
            $this->maxResultsPerPage = self::$maxResultsPerPage = $maxResultsPerPage;
        else
            $this->maxResultsPerPage = self::$maxResultsPerPage;
    }

    private function getNumbIndice($numbRes)
    {
        $resOfDiv = $numbRes%self::$maxResultsPerPage;
        if($resOfDiv > 0)
            return ((int)($numbRes/self::$maxResultsPerPage)+1);
        else
            return $numbRes/self::$maxResultsPerPage;
    }

    public function executeRecentTag()
    {
        $tag = $this->getRequest()->getParameter('tag');
        $act = $this->getRequest()->getParameter('act');

        $this->tag = $tag;

        $user = $this->getUser();

        if($user->isAuthenticated())
        {
            $userId = $user->getCurrentUser()->getId();
            $tagResult = myTag::getTagByName($tag);

            $userTag = UserTag::getUserTagByTagId($tagResult->getId(), $userId);

            // @TODO extract methods

            if($act == "add")
            {
                $this->act = true;
                if($userTag)
                {
                    $userTag->setPositive(true);
                    $userTag->setNegative(false);
                    $userTag->save();
                }
                else
                {
                    $this->setTagObj($userId, $tagResult->getId(), true, false);
                }
            }
            if($act == "sub")
            {
                $this->act = false;
                if($userTag)
                {
                    $userTag->setPositive(false);
                    $userTag->setNegative(true);
                    $userTag->save();
                }
                else
                {
                    $this->setTagObj($user->getCurrentUser()->getId(), $tagResult->getId(), false, true);
                }
            }
        }
    }

    // @TODO move to peer class

    private function setTagObj($userId, $tagId, $positiv, $negativ)
    {
        $userTagObj = new UserTag();
        $userTagObj->setUserId($userId);
        $userTagObj->setTagId($tagId);
        $userTagObj->setPositive($positiv);
        $userTagObj->setNegative($negativ);
        $userTagObj->save();
    }

    public function executeDeletedAnswers(sfWebRequest $request)
    {
        $questionId = $request->getParameter("question_id");

        $this->nav = $request->getParameter("nav");
        $this->initPagenation();
        $this->answers = AnswerPeer::getDeleteAnswer(self::$currentPage, self::$maxResultsPerPage, $questionId);
        $this->numbIndice = $this->getNumbIndice($this->answers->getNbResults());
    }

    private function setMetaTags($title, $description)
    {
        $title = ucwords($title);
        $title .= " - " . ucFirst(sfConfig::get("app_domain_name"));

        $this->getResponse()->setTitle($title);
        $this->getResponse()->addMeta('description', ucfirst($description));
    }
}