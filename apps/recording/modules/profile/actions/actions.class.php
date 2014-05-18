<?php

/**
 * profile actions.
 *
 * @package    recording
 * @subpackage profile
 * @author     Justin Vencel
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class profileActions extends sfActions
{

    static $currentPage = 1;
    static $maxResultsPerPage = 15;

    public function executeIndex(sfWebRequest $request)
    {
        $userId = $request->getParameter("userId");

        if($userId)
        {
            $this->user = UserPeer::getById($userId);

            if(!$this->user)
                $this->redirect("@homepage");
        }
        else
        {
            $user = $this->getUser();
            $this->user = $user->getCurrentUser();
        }

        // log a page view
        $views = new ProfileViews();
        $views->logView($userId, myUtil::getUserIp($request));

        $info = strip_tags($this->user->getInfo());
        $this->info = str_replace("\n", "<br/>", $info);

        $this->userRank = $this->getUserRank($this->user->getId());

        $this->currentPage = self::$currentPage;
        $this->maxResultsPerPage = self::$maxResultsPerPage;

        // check if profile is complete
        if(!$value = UserMetaPeer::getMetaValue($userId, 'profile-complete'))
        {
            $this->percent_complete = $this->user->getProfilePercentComplete();
        }

        $usable_name = $this->getUsableName($this->user);
        $user_description = ($info == "") ? "Learn a little about $usable_name." : $info;
        $this->setMetaTags($usable_name . ' User Bio', $user_description);
    }

    /**
     * Executes user activity action
     *
     * @param sfRequest $request A request object
     */
    public function executeUserActivity(sfWebRequest $request)
    {
        $userId = $request->getParameter("userId");

        if($userId)
        {
            $this->user = UserPeer::getById($userId);

            if(!$this->user)
                $this->redirect("@homepage");
        }
        else
        {
            $user = $this->getUser();
            $this->user = $user->getCurrentUser();
        }

        $this->userRank = $this->getUserRank($this->user->getId());
        $this->currentPage = self::$currentPage;
        $this->maxResultsPerPage = self::$maxResultsPerPage;

        $this->setMetaTags($this->getUsableName($this->user).' User Activity', 'A list of this users latest activity.');
    }

    public function getUserRank($userId)
    {
        return UserPeer::getRank($userId);
    }

    /**
     * Executes user edit action
     *
     * @param sfRequest $request A request object
     */
    public function executeUserEdit(sfWebRequest $request)
    {
        $user = $this->getUser();
        if($user->hasCredential('unconfirmed'))
        {
            $options = array(
                    'email' => $this->getUser()->getFlash('email', ''),
                    'display_name' => $this->getUser()->getFlash('displayName', ''),
                    'real_name' => $this->getUser()->getFlash('realName', '')
            );
            
            $this->form = new UserForm(null, $options);
            $this->currentUser = new User();
            $this->identifier = $request->getParameter("identifier");
            $this->is_new_user = true;
        }
        else
        {
            $userId = $user->getAttribute('userId');
            $this->currentUser = $user->getCurrentUser();

            $this->form = new UserForm(UserPeer::retrieveByPK($userId));
        }

        if($request->getMethod() == 'POST')
        {
            $this->form->bind($request->getParameter('user'));

            if ($this->form->isValid())
            {
                $userSave = $this->form->save();

                if($user->hasCredential('unconfirmed'))
                {
                    $this->initNewUser($this->identifier, $userSave->getId(), $user);
                }

                // award user if they have completed their profile
                $this->currentUser->checkForCompleteProfile();
                $this->forward('profile', 'index');
            }
        }
    }

    private function initNewUser($identifier, $userId, $user)
    {
        rpxAuthPeer::saveNewUser($identifier, $userId);
        $user->clearCredentials();
        $user->addCredentials('user');
        myUser::setUserId($userId);

        // if a referral, give credit
        if($this->getUser()->hasAttribute('referred_id'))
        {
            $referrer_id = $this->getUser()->getAttribute('referred_id', false);

            if($referrer_id)
            {
                $referral = MemberReferralPeer::retrieveByPK($referrer_id);

                if($referral)
                {
                    $referral->setNewMember(1);
                    $referral->save();
                }
            }
        }

        UserMessage::greetNewUser($userId);
    }
    /**
     * Executes user favorites action
     *
     * @param sfRequest $request A request object
     */
    public function executeUserFavorites(sfWebRequest $request)
    {
        $userId = $request->getParameter('userId');

        $this->initPagenation();

        if(!$userId)
        {
            $this->user = $this->getUser()->getCurrentUser();
        }
        else
        {
            $this->user = UserPeer::getById($userId);
            if(!$this->user)
                $this->redirect("@homepage");
        }
        $this->favoriteQuestions = QuestionPeer::getFavoriteQuestion(self::$currentPage, self::$maxResultsPerPage, $this->user->getId());

        $this->currentPage = self::$currentPage;
        $this->maxResultsPerPage = self::$maxResultsPerPage;

        $this->numbIndice = $this->getNumbIndice($this->favoriteQuestions->getNbResults());

        $this->userRank = $this->getUserRank($this->user->getId());

        $this->setMetaTags($this->getUsableName($this->user).' Favorites', 'A list of this users favorite questions.');
    }


    /**
     * Executes user settings action
     *
     * @param sfRequest $request A request object
     */
    public function executeUserSettings(sfWebRequest $request)
    {

        $user = $this->getUser();
        if($user->isAuthenticated())
        {
            $this->user = $user->getCurrentUser();
            $userId = $this->user->getId();

            $userTags = UserTag::getUserTagByUserId($userId);

            $userPositiveTags = array();
            $userNegativTags = array();

            foreach ($userTags as $userTag)
            {
                if($userTag->getPositive())
                    $userPositiveTags[] = $userTag;
                if($userTag->getNegative())
                    $userNegativeTags[] = $userTag;
            }

            if(isset($userPositiveTags))
                $this->userPositiveTags = $userPositiveTags;
            else
                $this->userPositiveTags = array();
            if(isset($userNegativeTags))
                $this->userNegativeTags = $userNegativeTags;
            else
                $this->userNegativeTags = array();

            $this->currentPage = self::$currentPage;
            $this->maxResultsPerPage = self::$maxResultsPerPage;

            $this->userRank = $this->getUserRank($userId);

            // email notification
            $this->notify = $this->user->getEmailOn();
        }
        else
            $this->redirect('@login');
    }

    public function executeSaveSettings(sfWebRequest $request)
    {
        $email_notification = $request->getParameter('emailnotify', false);
        $user_id = $request->getParameter('userid', false);

        $user_session = $this->getUser();

        if(!$user_id || !$user_session->isAuthenticated())
        {
            $this->redirect404();
        }

        $user = $user_session->getCurrentUser();

        if($user->getId() == $user_id)
        {
            $user->setEmailOn(($email_notification === false) ? 0 : 1);
            $user->save();
        }

        $this->forward('profile', 'userSettings');
    }

    /**
     * Executes user stats action
     *
     * @param sfRequest $request A request object
     */
    public function executeUserStats(sfWebRequest $request)
    {
        $userId = $request->getParameter('userId');

        if(!$this->getUser()->isAuthenticated() && !$userId)
        {
            $this->redirect("@homepage");
        }

        //$questionPage = $request->getParameter("questionPage");
        //$answerPage = $request->getParameter("answerPage");

        if($userId)
        {
            $this->user = UserPeer::getById($userId);
            if(!$this->user)
                $this->redirect("@homepage");
        }
        else
            $this->user = $this->getUser()->getCurrentUser();



        $userId = $this->user->getId();

        $this->setMetaTags($this->getUsableName($this->user).' User Stats', 'The latest user statistics, questions asked answered and voted on.');

        $userQuestion       = QuestionPeer::getByUser($userId);
        $userAnswer         = AnswerPeer::getByUser($userId);
        $this->userCommentCount   = User::getTotalCommentCount($userId);

        $this->userRank = $this->getUserRank($userId);

        $this->currentPage = self::$currentPage;
        $this->maxResultsPerPage = self::$maxResultsPerPage;

        $this->userGivenVote = ($this->getCountGivenVote($userId) == 0) ? 'Haven\'t voted? Try voting for the questions and answers you like!' : $this->getCountGivenVote($userId);
        $this->userReceivedVote = $this->getCountReceivedVote($userQuestion, $userAnswer);
        $this->userReceivedVote = ($this->userReceivedVote == 0) ? 'Try asking or answering questions in greater detail!' : $this->userReceivedVote;
        $this->userAnswer   = $userAnswer;
        $this->userQuestion = $userQuestion;
        //$this->userComment = $userComment;

        $awards = UserAwardPeer::getAwardsWithInfo($userId);
        $this->award_count = $this->getAwardCounts($awards);
    }

    private function getAwardCounts($awards)
    {
        $assistant = 0;
        $engineer = 0;
        $mastering = 0;

        if($awards)
        {
            foreach ($awards as $award)
            {
                if($award->getType() == 'assistant')
                    $assistant ++;
                elseif($award->getType() == 'engineer')
                    $engineer ++;
                else
                    $mastering ++;
            }
        }

        return array(
                'assistant' => $assistant,
                'engineer' => $engineer,
                'mastering' => $mastering
        );
    }

    private function getCountGivenVote($userId)
    {
        $questionVote = QuestionVotePeer::getByUserId($userId);
        $answerVote = AnswerVotePeer::getByUserId($userId);
        return count($questionVote) + count($answerVote);
    }

    private function getCountReceivedVote($questions, $answers)
    {
        $questionId = array();
        foreach ($questions as $question)
        {
            $questionId[] =  $question->getId();
        }

        $questionVote = QuestionVotePeer::getByQuestionId($questionId);

        $answerIds = array();
        foreach ($answers as $answer)
        {
            $answerIds[] =  $answer->getId();
        }

        $answerVote = AnswerVotePeer::getByAnswerIds($answerIds);
        return count($questionVote) + count($answerVote);

    }

    private function initPagenation()
    {
        $currentPage = $this->getRequest()->getParameter('currentPage');
        $maxResultsPerPage = $this->getRequest()->getParameter('maxResultsPerPage');

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
            return ((int)($numbRes/self::$maxResultsPerPage))+1;
        else
            return $numbRes/self::$maxResultsPerPage;
    }

    public function executeAddTags()
    {
        $tags = explode(' ', $this->getRequest()->getParameter('positiveTagsAutocom'));

        if(isset($tags[0]) && empty($tags[0]))
            $tags = explode(' ', $this->getRequest()->getParameter('negativeTagsAutocom'));

        $act = $this->getRequest()->getParameter('act');

        $user = $this->getUser();

        // @TODO very long method

        if($user->isAuthenticated())
        {
            $userId = $user->getCurrentUser()->getId();
            $tagsItems = array();
            $availablePositiveUserTag = array();
            $availableNegativeUserTag = array();
            if($tags && !empty($tags[0]))
            {
                $tags = array_unique($tags);
                $userTags = UserTag::getUserTagByUserId($userId);
                foreach ($tags as $tag)
                {
                    if(!empty($tag))
                    {
                        $flag = false;
                        foreach ($userTags as $userTag)
                        {
                            if($userTag->getTag() == $tag)
                            {
                                $flag = $userTag;
                            }
                        }

                        if($flag)
                        {
                            if($flag->getPositive())
                                $availablePositiveUserTag[] = $flag;
                            if($flag->getNegative())
                                $availableNegativeUserTag[] = $flag;
                        }

                        if(!$flag)
                        {

                            $tagObj = myTag::getTagByName($tag);

                            if(!$tagObj)
                            {
                                $newTagObj = new Tag();
                                $newTagObj->setName($tag);
                                $newTagObj->save();

                                $tagObj = $newTagObj;
                            }

                            $userTagObj = new UserTag();
                            $userTagObj->setUserId($userId);

                            $userTagObj->setTagId($tagObj->getId());

                            if($act == 'positive')
                                $userTagObj->setPositive(true);
                            if($act == 'negative')
                                $userTagObj->setNegative(true);

                            $userTagObj->save();
                        }
                    }
                }
            }
            if(isset($availablePositiveUserTag) && !empty($availablePositiveUserTag))
                $this->availablePositiveUserTag = $availablePositiveUserTag;
            if(isset($availableNegativeUserTag) && !empty($availableNegativeUserTag))
                $this->availableNegativeUserTag = $availableNegativeUserTag;

            if($act == 'positive')
                $this->tags = UserTag::getPositiveUserTagByUserId($userId);
            if($act == 'negative')
                $this->tags = UserTag::getNegativeUserTagByUserId($userId);

            $this->act = $act;
        }
    }

    public function executeAutocomplitTags(sfWebRequest $request)
    {
        $tags = $this->getRequest()->getParameter('q');

        $this->tags = TagPeer::getAll(null, array('like' => $tags.'%'));
    }

    public function executeDeleteTag()
    {
        $tagId = $this->getRequest()->getParameter('tagId');
        $act = $this->getRequest()->getParameter('act');
        $user = $this->getUser();

        if($user->isAuthenticated())
        {
            $userId = $user->getCurrentUser()->getId();
            $userTag = UserTag::getUserTagByTagId($tagId, $userId);
            $userTag->delete();

            if($act == "positive")
                $this->tags = UserTag::getPositiveUserTagByUserId($userId);
            if($act == "negative")
                $this->tags = UserTag::getNegativeUserTagByUserId($userId);

            $this->act = $act;
        }
    }

    public function executeFavoriteQuestion()
    {
        $this->question_id = $this->getRequest()->getParameter("question_id");

        $user = $this->getUser();

        $this->status = false;

        $questionFavorite = QuestionPeer::getFavoriteQuestionByUser($this->question_id, $user->getCurrentUser()->getId());
        if($questionFavorite)
        {
            $this->status = 'negativ';
            $questionFavorite->delete();
        }
        else
        {
            $this->status = 'positiv';
            UserFavoritePeer::saveNewQuestion($user->getCurrentUser()->getId(), $this->question_id);
        }
    }

    public function executeAuthorProfile(sfWebRequest $request)
    {
        $userId = $request->getParameter('userId');

        if($userId)
        {
            $user = UserPeer::retrieveByPK($userId);

            if($user)
            {
                $this->redirect("@profile?display_name=".myUtil::createSlug($user->getDisplayName())."&userId=".$user->getId(), 301);
            }
        }
        else
            $this->redirect404();
    }


    /**
     * @param sfRequest $request A request object
     *
     * @param string $title        The HTML page title tag
     * @param string $description  The HTML page meta descrioption tag
     */
    private function setMetaTags($title, $description)
    {

        $title = ucwords($title);
        $title .= " - " . ucFirst(sfConfig::get("app_domain_name"));

        $this->getResponse()->setTitle($title);
        $this->getResponse()->addMeta('description', ucfirst($description));

    }

    private function getUsableName(User $objUser)
    {
        return ($objUser->getDisplayName() == '') ? $objUser->getRealName() : $objUser->getDisplayName();
    }

    public function executeReferFriend(sfWebRequest $request)
    {
        $userId = $request->getParameter('userId');
        $user = $this->getUser();

        $this->currentPage = self::$currentPage;
        $this->maxResultsPerPage = self::$maxResultsPerPage;

        $this->user = $user->getCurrentUser();

        if($user->isAuthenticated() && $userId = $this->user->getId())
        {
            $this->points = MemberReferral::getRemainingPoints($userId);
            $this->contests = floor($this->points / sfConfig::get('app_referral_emails_per_week'));
            if($this->points == 0)
                $this->emails_for_next_entry = 3;
            else
                $this->emails_for_next_entry = sfConfig::get('app_referral_emails_per_week') % $this->points;


            // determine progress
            $this->referrals = MemberReferralPeer::getReferralCount($userId);
            $this->members_remaining = sfConfig::get('app_referral_members_for_shirt') - $this->referrals;

            $this->invite_message = 'I’m emailing because I want to let you know about RecordingQuestions.com, which is a free knowledge sharing site dedicated to sound recording.  You can ask any recording-related questions you want and also help out other folks by answering their questions.  Site members vote on questions and answers too, which is fun, and also makes it easy to find useful information.<br><br>I’ve already joined and I think you’d be a great addition to the community as well.  ';
        }
        else
        {
            $this->redirect404();
        }
    }

    public function executeSendReferral(sfWebRequest $request)
    {
        $user = $this->getUser();

        if(!$user->isAuthenticated())
        {
            $user->setAttribute('lastPageUri', $request->getPathInfo());
            $this->redirect('@login');
        }

        $params = $request->getParameterHolder()->getAll();

        $userId = $user->getCurrentUser()->getId();

        $valid = MemberReferral::validateInput($params);

        if($valid)
        {
            for($i=1; $i<=6; $i++)
            {
                $email = trim($params['email'.$i]);
                if($email != '' && !MemberReferralPeer::emailAlreadySent($email, $userId))
                {
                    $referral = new MemberReferral();

                    $referral->setEmail($email);
                    $referral->setHash(md5($email));
                    $referral->setUserId($userId);

                    $referral->sendEmail($params['invite'], $params['from']);
                    $referral->save();

                    $this->getUser()->setFlash('referral_sent', true);
                }
            }
        }

        $this->forward('profile', 'referFriend');
    }


    public function executeTrackReferral(sfWebRequest $request)
    {
        $userId = $request->getParameter('userId');
        $hash = $request->getParameter('hash');

        if($userId && $hash)
        {
            $referral = MemberReferralPeer::getByHash($userId, $hash);

            if(is_object($referral))
            {
                $this->getUser()->setAttribute('referred_id', $referral->getId());
                $referral->setUpdatedAt(date('Y-m-d H:i:s'));
                $referral->save();
            }
            $this->redirect('@homepage');
        }
        else
        {
            $this->redirect404();
        }
    }

    public function executeCheckReferralEmail(sfWebRequest $request)
    {
        $email = $request->getParameter('email');

        $result = json_encode(array('found' => false));

        if($email)
        {
            $userId = $this->getUser()->getCurrentUser()->getId();

            $referral = MemberReferralPeer::getByHash($userId, md5($email));

            if($referral)
            {
                $result = json_encode(array('found' => true));
            }
        }

        echo $result;
        exit;
    }

    public function executeAutocompleteCountry(sfWebRequest $request)
    {
        $search_text = $request->getParameter('q');
        $this->countries = Flag::searchCountries($search_text);
    }

    public function executeEditStudioImage(sfWebRequest $request)
    {
        $user_id = $request->getParameter('user_id');

        if($user_id)
        {
            $this->user = UserPeer::retrieveByPK($user_id);

        }

        if($request->getMethod() == 'POST')
        {
            $temp_image = $request->getParameter('upload-image-file-name');

            // resize and save image
            myUtil::resizeStudioImage($temp_image, $user_id);

            $this->redirect($this->user->getRoute());
        }
    }

    public function executeAddTwitterCredentials(sfWebRequest $request)
    {
        $username = $request->getParameter('twittername', '');
        $password = $request->getParameter('twitterpass', '');

        $twitter = new Twitter();

        $result = $twitter->checkUser($username, $password);

        if($result)
        {
            $userId = $this->getUser()->getCurrentUser()->getId();
            $result = $twitter->addNewTwitterAccount($userId, $username, $password);
        }

        echo json_encode(array('status' => $result));
        exit;
    }

    public function executeToggleTwitterStatus(sfWebRequest $request)
    {
        $userId = $this->getUser()->getCurrentUser()->getId();

        $twitter = new TwitterUser($userId);

        $result = $twitter->toggleStatus();

        echo json_encode(array('status' => $result));
        exit;
    }

    public function executeToggleTwitterType(sfWebRequest $request)
    {
        $userId = $this->getUser()->getCurrentUser()->getId();

        $twitter = new TwitterUser($userId);

        $result = $twitter->toggleType();

        echo json_encode(array('status' => $result));
        exit;
    }

    public function executeBadge(sfWebRequest $request)
    {
        if(!$this->getUser()->isAuthenticated())
        {
            $this->redirect('@homepage');
        }

        $this->user = $this->getUser()->getCurrentUser();
    }

    public function executeShowBadge(sfWebRequest $request)
    {
        $user_id         = $request->getParameter('user_id', false);
        $this->type      = $request->getParameter('type', 'default');
        $this->get_badge = $request->getParameter('get_badge', false);

        if($user_id)
        {
            $this->user = UserPeer::retrieveByPK($user_id);
        }

        // set image name
        $this->image = 'badge-' . $this->type;

        $this->setLayout(false);
        sfConfig::set('sf_web_debug', false);
    }
}