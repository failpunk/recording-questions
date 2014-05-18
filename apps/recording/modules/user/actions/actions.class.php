<?php

/**
 * user actions.
 *
 * @package    recording
 * @subpackage user
 * @author     Justin Vencel
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class userActions extends sfActions
{
    static $searchType = 'rank';
	static $maxResultsPerPage = 30;
    
   /**
    * Executes user awards action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
        $this->nav = $request->getParameter('nav', null);
        
        if(is_null($this->nav)) {
            self::$searchType = 'rank';
        } else {
            self::$searchType = $this->nav;
        }

        $this->getUserInfo(self::$searchType, '', self::$maxResultsPerPage);

        if($this->user_stats) {
            $this->no_results = false;
        } else {
            $this->no_results = true;
        }

        $this->users = $this->user_stats;
    }


   /**
    * Executes user newest action
    *
    * @param sfRequest $request A request object
    */
    public function executeUserNewest(sfWebRequest $request)
    {
        $request->setParameter('nav', 'newest');
        $this->forward('user', 'index');
    }


   /**
    * Executes user oldest action
    *
    * @param sfRequest $request A request object
    */
    public function executeUserOldest(sfWebRequest $request)
    {
        $request->setParameter('nav', 'oldest');
        $this->forward('user', 'index');
    }


    public function executeFilterUsers(sfWebRequest $request)
    {
        $likeString = $request->getParameter('q', '');
        $this->nav = $request->getParameter('nav', 'rank');

        if(is_null($this->nav) or $this->nav == '') {
            $this->nav = 'rank';
        }
        
        $this->getUserInfo($this->nav, $likeString, self::$maxResultsPerPage);

        if($this->user_stats) {
            $no_results = false;
        } else {
            $no_results = true;
        }

        return $this->renderPartial('user/filteredUsers', array(
                                                    'users' => $this->user_stats,
                                                    'nav' => $this->nav,
                                                    'no_results' => $no_results
        ));
    }

    public function getUserInfo($filterType, $likeString, $maxResultsPerPage)
    {
        // get list of ids sorted by type
        if($filterType == 'rank') {
            $user_ids = UserPeer::getUserLike($likeString, $maxResultsPerPage, 'experience');
        }

        if($filterType == 'oldest') {
            $user_ids = UserPeer::getUserLike($likeString, $maxResultsPerPage, 'oldest');
        }

        if($filterType == 'newest') {
            $user_ids = UserPeer::getUserLike($likeString, $maxResultsPerPage, 'newest');
        }
        
        // use ids to get user info
        if($user_ids)
        {
            $this->user_stats = UserPeer::getStats($user_ids);
        }
    }
}
