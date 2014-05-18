<?php

/**
 * question actions.
 *
 * @package    recording
 * @subpackage question
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class questionActions extends sfActions
{
    /**
     * Executes ask a question action
     *
     * @param sfRequest $request A request object
     */
    public function executeAskQuestion(sfWebRequest $request)
    {
        if($request->getMethod() == "POST")
        {
            $question = $this->updateQuestionFromRequest();

            fpEvent::fire('question.beforeSave');

            $question->save();

            fpEvent::fire('question.save', $question);

//            $question->sendTweets();
//            - Moved this to cron

            $this->redirect('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId());
        }
    }

    public function executeAskQuestionRoot(sfWebRequest $request)
    {
        $this->getContext()->getConfiguration()->loadHelpers(array('Url'));
        $this->redirect(url_for('@ask_question'), 301);
    }

    public function validateAskQuestion()
    {
        // User must have an account to ask questons.
        if(!$this->getUser()->isAuthenticated())
        {
            $this->getContext()->getConfiguration()->loadHelpers('Url');

            $this->getUser()->setFlash('display_independant_message', true);
            $this->getUser()->setFlash('display_independant_type', 'three');
            $message = '<h4>That\'s Great...We Love New Questions!</h4>
                        <p style="margin-bottom:10px;">In order for us to keep all the questions organized, we need you to take a moment and let us know who you are.</p> <p>Select the service below that you would like to login with and we will get your question up ASAP.</p>';
            $this->getUser()->setFlash('display_independant_text', $message);
            $this->redirect('@login');
        }

        // check for spamming
        fpEvent::fire('question.details', 0);

        // if user is marked as spammer and they have less than 100 experience
        if($this->getUser()->hasCredential('question-spamer') && $this->getUser()->getCurrentUser()->getExperienceScore() < sfConfig::get("app_experience_needed_post_limit"))
        {
            $this->getUser()->setFlash('display_independant_message', true);
            $this->getUser()->setFlash('independant_message_type', 'three');
            $message = '<h4>You can only ask 1 question every two minutes!</h4>
                        <p style="margin-bottom:10px;">In order for us to help avoid spam we limit new members to only 2 questions per minute.</p> <p>Once you collect a few more experience points we will remove this restriction.</p>';
            $this->getUser()->setFlash('display_independant_text', $message);

            $this->isSpam = true;
        }


        // @TODO move to QuestionTagValidator

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            // if user is marked as spammer and they have less than 100 experience
            if($this->getUser()->hasCredential('question-spamer') && $this->getUser()->getCurrentUser()->getExperienceScore() < sfConfig::get("app_experience_needed_post_limit"))
            {
                return false;
            }

            // validate tags
            $tags = $this->getRequest()->getParameter('question_tags');
            $this->validateTags($tags);

            // validate notify email
            if($this->getRequest()->getParameter('notify_checkbox'))
            {
                $this->notify_email_checked = true;

                if(!myUtil::check_email_address($this->getRequest()->getParameter('notify_email')))
                {
                    $this->getRequest()->setError('notify_email', 'The email address you would like us to send updates to does not seem to be valid.');
                }
            }

            if($this->getRequest()->hasErrors()) return false;
            else return true;
        }
    }

    public function handleErrorAskQuestion()
    {
        return sfView::SUCCESS;
    }

    /**
     * Executes question detail action
     *
     * @param sfRequest $request A request object
     */
    public function executeQuestionDetail(sfWebRequest $request)
    {
        $questionId = $request->getParameter('question_id');
        $this->nav = $request->getParameter('nav');
        $this->question = null;
        $this->user_question = false;
        $this->vote_type = '';

        $questionObj = new QuestionPeer();
        $questionObj->updateVisited($questionId);

        $this->question = QuestionPeer::retrieveByPK($questionId);

        if($this->question->getVisible() || $this->getUser()->hasCredential('admin'))
        {
            // set the meta tags
            $this->question_title = $this->question->getTitle();

            $this->setMetas($this->question_title, $this->question->getDescription());

            if(!$this->question)
                $this->redirect404();

            $this->ownQuestion = false;

            if($this->getUser()->isAuthenticated())
            {
                $userId = $this->getUser()->getCurrentUser()->getId();
                if($userId == $this->question->getUserId())
                {
                    $this->ownQuestion = true;
                }
                $this->userFavorite = UserFavoritePeer::getFavoriteQuestionByUserIdAndQuestionId($userId, $questionId);
                $questionVote = QuestionVotePeer::getVotesByUser($questionId, $userId);
                if($questionVote)
                {
                    if($questionVote->getPositive())
                    {
                        $this->vote = true;
                        $this->vote_type = 'add';
                    }
                    if($questionVote->getNegative())
                    {
                        $this->vote = false;
                        $this->vote_type = 'sub';
                    }
                }
            }

            $this->questionComments = QuestionCommentPeer::getQuestionComment($questionId);
            $this->countQuestionComments = QuestionCommentPeer::countByQuestionId($questionId);

            fpEvent::fire('question.details', $this->question);

            $this->user = $this->getUser()->getUserById($this->question->getUserId());

            $this->answers = $this->getAnswerToQuestion($questionId, $this->nav);

            if($this->getUser()->isAuthenticated())
            {
                if($this->getUser()->getCurrentUser()->getId() == $this->question->getUserId())
                {
                    $this->user_question = true;
                }

                $this->answerVote = AnswerVotePeer::getByAnswers($this->answers, $this->getUser()->getCurrentUser()->getId());
            }
            else
            {
                // save the route to this page in case use decides to login from link in answer form
                $this->getUser()->setAttribute('lastPageUri', $request->getPathInfo());
                $this->answerVote = null;
            }

            fpEvent::fire('answer.details', $this->answer);
            fpEvent::fire('comment.details');
            fpEvent::fire('votes.check');
            fpEvent::fire('offensive.save', $questionId);
        }
        else
            $this->redirect404();
    }

    private function checkQuestionForLock($questionId)
    {
        return QuestionPeer::checkForLock($questionId);
    }

    public function executeAnswerQuestion(sfWebRequest $request)
    {
        $answer = $request->getParameter('answer');
        $question_id = $request->getParameter('question_id');

        if($answer && !$this->checkQuestionForLock($question_id))
        {
            $user = $this->getUser()->getCurrentUser();

            $answerObj = new Answer();
            $answerObj->setQuestionId($question_id);
            $answerObj->setAnswer($answer);
            $answerObj->setUserId($user->getId());
            $answerObj->setCreatedAt(time());

            $answerObj->save();

            // @TODO move to event handler, hard code
            // --------------------------------
            $data = fpNotification::modelsToArray(
                    array(
                    'answer' => $answerObj
                    )
            );

            fpNotification::addUserCustomMessage($answerObj->getQuestion()->getUserId(), 'answer_to_question', $data );
            // --------------------------------

            // send notification email
            $email = new Mail();
            $email->sendNotificationEmail($question_id, 'answer', $answerObj);

            fpEvent::fire('answer.save', $this->answer);
        }

        $question = QuestionPeer::retrieveByPK($question_id);

        $this->redirect('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId());
    }

    public function handleErrorAnswerQuestion()
    {
        $question_id = $this->getRequest()->getParameter('question_id');

        // set flag in flash to scroll back down to input box on error.
        $this->getUser()->setFlash('answerQuestionError', true);

        $this->forward('question', 'questionDetail');
        return sfView::SUCCESS;
    }

    public function executeRssForQuestionDetail(sfWebRequest $request)
    {
        $questionId = $request->getParameter("questionId");

        $question = QuestionPeer::retrieveByPK($questionId);
        $answers = $this->getAnswerToQuestion($questionId, 'newest', sfConfig::get('app_rss_conf_per_page'));

        $feed = new sfRssFeed();
        $feed->initialize(
                array(
                'title'       => $question->getTitle() ,
                'link'        => "@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId(),
                'authorEmail' => $question->getUser()->getEmail(),
                'authorName'  => $question->getUser()->getDisplayName()
        ));

        foreach ($answers as $answer)
        {
            $item = new sfFeedItem();
            $item->setTitle($answer->getAnswer());
            $item->setLink('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId().'#'.$answer->getId());
            $item->setAuthorName($answer->getUser()->getDisplayName());
            $item->setPubdate(strtotime($answer->getCreatedAt()));
            $item->setDescription($answer->getAnswer());

            $feed->addItem($item);
        }

        $this->feed = $feed;
    }

    public function updateQuestionFromRequest($question = null)
    {
        $questionRequest = $this->getRequest()->getParameter('question');
        $tags = $this->getRequest()->getParameter('question_tags');
        $user = $this->getUser()->getCurrentUser();

        if(!$question)
        {
            $question = new Question();
            $question->setUserId($user->getId());
        }
        else
        {
            $question->removeAllTags();
        }

        $question->addTag(preg_split('/\s+/', trim($tags) ) );

        if($questionRequest['title'])
        {
            $question->setTitle($questionRequest['title']);
        }

        if($questionRequest['description'])
        {
            $question->setDescription($questionRequest['description']);
        }

        if($this->getRequest()->getParameter('notify_checkbox'))
        {
            $question->setNotifyEmail($this->getRequest()->getParameter('notify_email'));
        }

        return $question;
    }

    public function executeFavoriteQuestion()
    {
        $this->question_id = $this->getRequest()->getParameter("question_id");

        $user = $this->getUser();

        $this->status = 'negativ';

        if($user->isAuthenticated())
        {
            $questionFavorite = QuestionPeer::getFavoriteQuestionByUser($this->question_id, $user->getCurrentUser()->getId());
            if($questionFavorite)
            {
                $questionFavorite->delete();
            }
            else
            {
                $this->status = 'positiv';
                UserFavoritePeer::saveNewQuestion($user->getCurrentUser()->getId(), $this->question_id);
            }
        }
    }

    public function executeUpdateVote(sfWebRequest $request)
    {
        //TODO: Justin - This process needs to be re-thought out
        $answer_id = $this->getRequest()->getParameter('answer_id');
        $vote = $this->getRequest()->getParameter('vote');

        $user = $this->getUser();

        $answer = AnswerPeer::retrieveByPK($answer_id);

        $requestInfo = $request->getPathInfoArray();
        if($requestInfo['REMOTE_ADDR'])
            $user_ip = $requestInfo['REMOTE_ADDR'];
        else
            $user_ip = '';

        if($answer_id && $vote && !$this->checkQuestionForLock($answer->getQuestionId()))
        {
            if($this->checkForUserVotingForAnswer($user, $answer, $vote))
            {
                $answerVote = new AnswerVote($user->getCurrentUser());

                $answerVote->setAnswerId($answer_id);
                $answerVote->setUserId($user->getCurrentUser()->getId());

                if($vote == "add")
                {
                    $answerVote->setPositive(true);
                    $answerVote->setUserIp($user_ip);
                    $countVote = AnswerPeer::updateVote($answer_id, true);
                    $this->vote = true;
                }
                if($vote == "sub")
                {
                    $answerVote->setNegative(true);
                    $answerVote->setUserIp($user_ip);
                    $countVote = AnswerPeer::updateVote($answer_id, false);
                    $this->vote = false;
                }
                $answer->save();
                $answerVote->save();

                $this->countVote = $answer->getTotalVotes();
                fpEvent::fire('expereinceVote.afterSave', $answer, $vote);
            }
            else
            {
                $answerVote = AnswerVotePeer::getByUserId($user->getCurrentUser()->getId(), $answer_id);

                if($answerVote)
                {
                    $date = $answerVote->getCreatedAt(null);

                    $flag = false;

                    if($date->format('U') + 86400 > time() )
                    {
                        if(($vote == "add") && $answerVote->getPositive() )
                        {
                            $answerVote->delete();
                            $countVote = AnswerPeer::updateVote($answer_id, true, true);
                            $flag = true;
                            fpEvent::fire('expereinceVote.afterSave', $answer, $vote."Reverse");
                        }
                        elseif(($vote == "add") && $answerVote->getNegative() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $answerVote->setPositive(true);
                            $answerVote->setNegative(false);
                            $answerVote->setUserIp($user_ip);
                            $answerVote->save();
                            AnswerPeer::updateVote($answer_id, false, true);
                            $countVote = AnswerPeer::updateVote($answer_id, true, false);
                            $flag = true;
                            $this->vote = true;

                            fpEvent::fire('expereinceVote.afterSave', $answer, "subReverse");
                            fpEvent::fire('expereinceVote.afterSave', $answer, $vote);
                        }

                        if(($vote == "sub") && $answerVote->getNegative())
                        {
                            $answerVote->delete();
                            $countVote = AnswerPeer::updateVote($answer_id, false, true);
                            $flag = true;
                            fpEvent::fire('expereinceVote.afterSave', $answer, $vote."Reverse");
                        }
                        elseif(($vote == "sub") && $answerVote->getPositive() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $answerVote->setPositive(false);
                            $answerVote->setNegative(true);
                            $answerVote->setUserIp($user_ip);
                            $answerVote->save();
                            AnswerPeer::updateVote($answer_id, true, true);
                            $countVote = AnswerPeer::updateVote($answer_id, false, false);
                            $flag = true;
                            $this->vote = false;

                            fpEvent::fire('expereinceVote.afterSave', $answer, "addReverse");
                            fpEvent::fire('expereinceVote.afterSave', $answer, $vote);
                        }
                    } else
                    {
                        $this->is_old = true;
                        $flag = true;

                        if(($vote == "add") && $answerVote->getPositive() )
                        {
                            $this->vote = true;
                        }
                        elseif(($vote == "add") && $answerVote->getNegative() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $this->vote = false;
                        }

                        if(($vote == "sub") && $answerVote->getNegative())
                        {
                            $this->vote = false;
                        }
                        elseif(($vote == "sub") && $answerVote->getPositive() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $this->vote = true;
                        }
                    }

                    if(!$flag)
                    {
                        $this->vote = $vote;
                    }
                }
                if(isset($countVote))
                    $this->countVote = $countVote;
                else
                    $this->countVote = $answer->getTotalVotes();
            }
            $this->answer = $answer;
            $this->voteForTooltips = $vote;
            //$this->answerVote = AnswerVotePeer::getByAnswers($answer, $user->getCurrentUser()->getId());
        }
        else
            $this->redirect404();
    }

    public function executeUpdateVoteForQuestion(sfWebRequest $request)
    {
        //TODO: Justin - This process needs to be re-thought out
        $question_id = $this->getRequest()->getParameter('question_id');
        $vote = $this->getRequest()->getParameter('vote');

        $user = $this->getUser();

        $requestInfo = $request->getPathInfoArray();
        if($requestInfo['REMOTE_ADDR'])
            $user_ip = $requestInfo['REMOTE_ADDR'];
        else
            $user_ip = '';

        if($question_id && $vote && !$this->checkQuestionForLock($question_id))
        {
            $question = QuestionPeer::retrieveByPK($question_id);
            $this->question_id = $question_id;
            if($this->checkForUserVotingForQuestion($user, $question, $vote))
            {
                $questionVote = new QuestionVote($user->getCurrentUser()->getId());

                $questionVote->setQuestionId($question_id);
                $questionVote->setUserId($user->getCurrentUser()->getId());

                if($vote == "add")
                {
                    $questionVote->setPositive(true);
                    $questionVote->setUserIp($user_ip);
                    $countVote = QuestionPeer::updateVote($question_id, true);
                    $this->vote = true;
                }
                if($vote == "sub")
                {
                    $questionVote->setNegative(true);
                    $questionVote->setUserIp($user_ip);
                    $countVote = QuestionPeer::updateVote($question_id, false);
                    $this->vote = false;
                }
                $questionVote->save();

                $this->countVote = $countVote;
                fpEvent::fire('expereinceVote.afterSave', $question, $vote);
            }
            else
            {
                $questionVote = QuestionVotePeer::getVotesByUser($question_id, $user->getCurrentUser()->getId());

                if($questionVote )
                {
                    $date = $questionVote->getCreatedAt(null);

                    $flag = false;
                    if($date->format('U') + 86400 > time())
                    {
                        if(($vote == "add") && $questionVote->getPositive())
                        {
                            $questionVote->delete();
                            $countVote = QuestionPeer::updateVote($question_id, true, true);
                            $flag = true;
                            fpEvent::fire('expereinceVote.afterSave', $question, $vote."Reverse");
                        }
                        elseif(($vote == "add") && $questionVote->getNegative() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $questionVote->setPositive(true);
                            $questionVote->setNegative(false);
                            $questionVote->setUserIp($user_ip);
                            $questionVote->save();
                            QuestionPeer::updateVote($question_id, false, true);
                            $countVote = QuestionPeer::updateVote($question_id, true, false);
                            $flag = true;
                            $this->vote = true;

                            fpEvent::fire('expereinceVote.afterSave', $question, "subReverse");
                            fpEvent::fire('expereinceVote.afterSave', $question, $vote);
                        }

                        if(($vote == "sub") && $questionVote->getNegative())
                        {
                            $questionVote->delete();
                            $countVote = QuestionPeer::updateVote($question_id, false, true);
                            $flag = true;
                            fpEvent::fire('expereinceVote.afterSave', $question, $vote."Reverse");
                        }
                        elseif(($vote == "sub") && $questionVote->getPositive() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $questionVote->setPositive(false);
                            $questionVote->setNegative(true);
                            $questionVote->setUserIp($user_ip);
                            $questionVote->save();
                            QuestionPeer::updateVote($question_id, true, true);
                            $countVote = QuestionPeer::updateVote($question_id, false, false);
                            $flag = true;
                            $this->vote = false;

                            fpEvent::fire('expereinceVote.afterSave', $question, "addReverse");
                            fpEvent::fire('expereinceVote.afterSave', $question, $vote);
                        }
                    } else
                    {
                        $this->is_old = true;
                        $flag = true;

                        if(($vote == "add") && $questionVote->getPositive() )
                        {
                            $this->vote = true;
                        }
                        elseif(($vote == "add") && $questionVote->getNegative() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $this->vote = false;
                        }

                        if(($vote == "sub") && $questionVote->getNegative())
                        {
                            $this->vote = false;
                        }
                        elseif(($vote == "sub") && $questionVote->getPositive() && $this->checkForAction($user->getCurrentUser()->getId(), $vote))
                        {
                            $this->vote = true;
                        }
                    }

                    if(!$flag)
                    {
                        $this->vote = $vote;
                    }
                }

                if(isset($countVote))
                    $this->countVote = $countVote;
                else
                    $this->countVote = $question->getTotalVotes();
            }
            $this->question = QuestionPeer::retrieveByPK($question_id);
            $this->voteForTooltips = $vote;
        }
        else
            $this->redirect404();
    }

    public function executeBestAnswer(sfWebRequest $request)
    {
        $question_id = $request->getParameter('question_id');
        $answer_id = $request->getParameter('answer_id');

        $allAnswers = AnswerPeer::getAnswerByQuestion($question_id);

        if(!$this->checkQuestionForLock($question_id))
        {

            $flag = false;
            foreach ($allAnswers as $answer)
            {
                if($answer->getBestanswer() && $answer->getId() != $answer_id)
                {
                    $answer->setBestanswer(false);
                    $answer->save();
                    $flag = true;
                }
            }

            $answerObj = AnswerPeer::retrieveByPK($answer_id);
            if(!$answerObj->getBestanswer())
            {
                $answerObj->setBestanswer(true);
                $answerObj->save();

                if(!$flag)
                    fpEvent::fire('expereinceBestAnswer.afterSave', $answerObj);
            }
            else
            {
                $answerObj->setBestanswer(false);
                $answerObj->save();

                fpEvent::fire('expereinceUnsetBestAnswer.afterSave', $answerObj);
            }
        }

        $question = QuestionPeer::retrieveByPK($question_id);
        $this->redirect('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId());
    }

    private function getAnswerToQuestion($questionId, $orderBy = '', $limit = null)
    {
        return AnswerPeer::getAnswerByQuestion($questionId, $orderBy, $limit);
    }

    // @TODO move to tool lib
    private function get_time_difference( $start )
    {
        $uts['start']      =    strtotime( $start );
        $uts['end']        =    time();//strtotime( $end );
        if( $uts['start']!==-1 && $uts['end']!==-1 )
        {
            if( $uts['end'] >= $uts['start'] )
            {
                $diff    =    $uts['end'] - $uts['start'];
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );
                return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        return( false );
    }


    public function executeSearch()
    {
        $this->query = $this->getRequest()->getPostParameter('q');

        $this->page = $this->getRequestParameter('p', 1);

        $defaultOptions = array(
                'weights' => array(100, 1),
                'sort'    => sfSphinxClient::SPH_SORT_EXTENDED,
                'sortby'  => '@weight DESC',
                'mode' => sfSphinxClient::SPH_MATCH_EXTENDED
        );

        $options = array_merge($defaultOptions, sfConfig::get('app_sphinx_related_question', array()));


        if (!empty($this->query))
        {
            $sphinx = new fpSphinxClient($options);
            
            // tidy up the string
            $this->query = preg_replace('/[?]/', '', $this->query);
            $this->query = preg_replace('/[-]/', ' ', $this->query);

            // remove worthless words before searching
            $this->query = fpSphinxClient::removeCommonTerms($this->query);

            $search = preg_replace('/\s+/', ' | ', $this->query);

            $res = $sphinx->search('@* ' . $search, 'question');

            $this->pager = new fpSphinxPager('Question', $options['limit'], $sphinx);
            $this->pager->setPage($this->page);
            $this->pager->setPeerMethod('retrieveByPKs');
            $this->pager->init();
        }
    }


    public function executeAutocomplitTags(sfWebRequest $request)
    {

        $question = $this->getRequest()->getParameter('q');
        $this->tags = TagPeer::getAll(null, array('like' => $question.'%'));

    }


    private function checkForUserVotingForAnswer($user, $answer, $vote)
    {
        $userId = $user->getCurrentUser()->getId();

        if(!$user->isAuthenticated())
            return false;


        if($userId == $answer->getUserId())
            return false;

        if($user->hasCredential('vote-spamer'))
            return false;

        if(!$this->checkForAction($userId, $vote))
            return false;

        $AnswerVote = AnswerVotePeer::getByUserId($userId, $answer->getId());
        if($AnswerVote)
            return false;
        else
            return true;
    }

    private function checkForAction($userId, $vote = null, $action = null)
    {
        if(!$action)
        {
            if($vote == 'add')
                $action = 'upvote';
            else
                $action = 'downvote';
        }

        return fpExperience::checkForAction($userId, $action);
    }

    private function checkForUserVotingForQuestion($user, $question, $vote)
    {
        $userId = $user->getCurrentUser()->getId();

        if(!$user->isAuthenticated())
            return false;

        if($userId == $question->getUserId())
            return false;

        if($user->hasCredential('vote-spamer'))
            return false;

        if(!$this->checkForAction($userId, $vote))
            return false;

        $QuestionVote = QuestionVotePeer::getByUserId($userId, $question->getId());
        if($QuestionVote)
        {
            return false;
        }
        else
            return true;
    }


    public function executeAddComment()
    {
        $this->negativAddComment = true;

        if($this->getUser()->isAuthenticated())
        {
            $userId = $this->getUser()->getCurrentUser()->getId();
            $this->questionId = $this->getRequest()->getParameter('question_id');
            $answerId = $this->getRequest()->getParameter('answer_id');

            $question = QuestionPeer::retrieveByPK($this->questionId);

            if($question && !$this->checkQuestionForLock($this->questionId))
            {
                // let user post comments to their own answers, unless a guest
                if($userId == $question->getUserId())
                {
                    $this->answerId = $answerId;
                    $this->negativAddComment = false;
                }
                elseif($this->checkForAction($userId, "", 'add_comment') )
                {
                    $this->answerId = $answerId;
                    $this->negativAddComment = false;
                }
            }
        }
    }

    public function executeAddQuestionComment()
    {
        $this->negativAddComment = true;

        if($this->getUser()->isAuthenticated())
        {
            $userId = $this->getUser()->getCurrentUser()->getId();
            $questionId = $this->getRequest()->getParameter('question_id');

            $question = QuestionPeer::retrieveByPK($questionId);

            if(!$this->checkQuestionForLock($questionId))
            {
                // let user post comments to their own answers, unless a guest
                if($userId == $question->getUserId())
                {
                    $this->questionId = $questionId;
                    $this->negativAddComment = false;
                }
                elseif($this->checkForAction($userId, "", 'add_comment') )
                {
                    $this->questionId = $questionId;
                    $this->negativAddComment = false;
                }
            }
        }
    }

    public function handleErrorSaveComment()
    {
        $this->forward('question', 'addComment');
        return sfView::SUCCESS;
    }

    public function handleErrorSaveQuestionComment()
    {
        $this->forward('question', 'addQuestionComment');
        return sfView::SUCCESS;
    }

    public function executeSaveComment()
    {
        $comment        = $this->getRequest()->getParameter('comment');
        $answerId       = $this->getRequest()->getParameter('answer_id');
        $this->status   = $this->getRequest()->getParameter('status');

        $user = $this->getUser();

        $answer = AnswerPeer::retrieveByPK($answerId);
        $this->questionId = $answer->getQuestionId();

        if(!empty($comment) && !$this->checkQuestionForLock($answer->getQuestionId()))
        {
            $user_id = $this->getUser()->getCurrentUser()->getId();
            $answerComment = AnswerComment::addComment($answer->getId(), $comment, $user_id);

            // @TODO move to event handler, hard code
            // --------------------------------
            $data = fpNotification::modelsToArray(
                    array(
                    'answer' => $answer
                    )
            );

            fpNotification::addUserCustomMessage($answer->getUserId(), 'comment_to_answer', $data );
            // --------------------------------

            // send notification email
            $email = new Mail();
            $email->sendNotificationEmail($answer->getQuestionId(), 'comment', $answerComment);

            fpEvent::fire('comment.save', "answer");
        }

        $this->answerId = $answerId;
        $this->comments = AnswerCommentPeer::getAswerComment($answerId);
    }

    public function executeSaveQuestionComment()
    {
        $comment        = $this->getRequest()->getParameter('comment');
        $questionId     = $this->getRequest()->getParameter('question_id');
        $this->status   = $this->getRequest()->getParameter('status');

        if(!empty($comment) && !$this->checkQuestionForLock($questionId))
        {
            $user_id = $this->getUser()->getCurrentUser()->getId();
            $questionComment = QuestionComment::addComment($questionId, $comment, $user_id);

            // @TODO move to event handler, hard code
            // --------------------------------
            $question = QuestionPeer::retrieveByPK($questionId);

            $data = fpNotification::modelsToArray(
                    array(
                    'question' => $question
                    )
            );

            fpNotification::addUserCustomMessage($question->getUserId(), 'comment_to_question', $data );
            // --------------------------------

            // send notification email
            $email = new Mail();
            $email->sendNotificationEmail($questionId, 'comment', $questionComment);

            fpEvent::fire('comment.save', "question");
        }

        $this->questionId = $questionId;
        $this->comments = QuestionCommentPeer::getQuestionComment($questionId);
    }

    public function executeShowAnswerComment()
    {
        $this->status   = $this->getRequest()->getParameter('status');
        $this->answerId = $this->getRequest()->getParameter('answer_id');
        $this->questionId = $this->getRequest()->getParameter('question_id');
        $this->comments = AnswerCommentPeer::getAswerComment($this->answerId);
        fpEvent::fire('comment.details', $this->comments);
    }

    public function executeShowQuestionComment()
    {
        $this->status   = $this->getRequest()->getParameter('status');
        $this->questionId = $this->getRequest()->getParameter('question_id');
        $this->comments = QuestionCommentPeer::getQuestionComment($this->questionId);

        fpEvent::fire('comment.details', $this->comments);
    }

    public function executeOffensiveQuestion()
    {
        if(!$this->getUser()->hasCredential('offensive-spamer'))
        {
            $questionId = $this->getRequest()->getParameter('questionId');

            $userId = $this->getUser()->getCurrentUser()->getId();

            $user = UserPeer::getById($userId);
            if($user->getExperienceScore() >= sfConfig::get('app_experience_needed_offensive'))
            {
                if(!QuestionOffensivePeer::getByUserId($userId, $questionId) && !$this->checkQuestionForLock($questionId))
                {
                    $question = new QuestionPeer();
                    $question->updateOffensiveQuestion($questionId);

                    QuestionOffensivePeer::addOffensive($userId, $questionId);

                    fpEvent::fire('offensive.save', $questionId);
                }
            }
        }
    }

    public function executeOffensiveAnswer()
    {
        if(!$this->getUser()->hasCredential('offensive-spamer'))
        {
            $answerId = $this->getRequest()->getParameter('answerId');

            $userId = $this->getUser()->getCurrentUser()->getId();

            $answer = AnswerPeer::getByIdPk($answerId);

            if(!AnswerOffensivePeer::getByUserId($userId, $answerId) && !$this->checkQuestionForLock($answer->getQuestionId()))
            {
                $answer = new AnswerPeer();
                $answer->updateOffensiveAnswer($answerId);

                AnswerOffensivePeer::addOffensive($userId, $answerId);

                fpEvent::fire('offensive.save', $answerId);
            }
        }
    }

    public function executeGetUserVoting()
    {
        $question_id = $this->getRequest()->getParameter('question_id');
        $user_id = $this->getUser()->getCurrentUser()->getId();

        $arrVotes = array();

        if($this->getUser()->isAuthenticated() && $question_id && $user_id)
        {
            $question_votes = QuestionVotePeer::getVotesByUser($question_id, $user_id);
            $answer_votes = AnswerVotePeer::getAllAnswerVotesForQuestionByUser($question_id, $user_id);

            // votes for the question
            $arrQuestionVotes = array(
                    "posttype" => 'question',
                    "id" => $question_votes->getQuestionId(),
                    "votetype" => ($question_votes->getWeight() == sfConfig::get('app_experience_upvote')) ? 'upvote' : 'downvote'
            );

            $arrVotes[] = $arrQuestionVotes;

            // votes for the answers
            foreach($answer_votes as $vote)
            {
                $arrAnswerVotes = array(
                        "posttype" => 'answer',
                        "id" => $vote['id'],
                        "votetype" => ($vote['weight'] == sfConfig::get('app_experience_upvote')) ? 'upvote' : 'downvote'
                );

                $arrVotes[] = $arrAnswerVotes;
            }
        }

        return $this->renderText(json_encode($arrVotes));

    }

    public function executeEditQuestion(sfWebRequest $request)
    {
        $questionId = $request->getParameter("question_id");
        $save       = $request->getParameter("save");

        $this->question = QuestionPeer::getByIdPk($questionId);

        if(!$this->checkQuestionForLock($questionId))
        {
            if(!$this->getUser()->hasCredential('admin'))
            {
                if($this->question->getUserId() != $this->getUser()->getCurrentUser()->getId())
                    $this->redirect404();
            }
            if ($this->getRequest()->getMethod() == sfRequest::POST && $save)
            {
                $question = $this->updateQuestionFromRequest($this->question);

                $question->save();

                $this->redirect('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId());
            }
        }
        else
            $this->redirect('@question_detail?question_title='.myUtil::createSlug($this->question->getTitle()).'&question_id='.$this->question->getId());
    }

    public function validateEditQuestion()
    {
        // @TODO move to QuestionTagValidator
        $save = $this->getRequest()->getParameter("save");

        if ($this->getRequest()->getMethod() == sfRequest::POST && $save)
        {
            $tags = $this->getRequest()->getParameter('question_tags');
            $this->validateTags($tags);

            if($this->getRequest()->hasErrors())
                return false;
            else
                return true;
        }
        else
            return true;
    }

    public function handleErrorEditQuestion()
    {
        $questionId = $this->getRequest()->getParameter("question_id");
        $this->question = QuestionPeer::getByIdPk($questionId);
        return sfView::SUCCESS;
    }

    public function executeEditTags(sfWebRequest $request)
    {
        $questionId = $request->getParameter("question_id");

        $this->question = QuestionPeer::getByIdPk($questionId);

        $user = $this->getUser()->getCurrentUser();

        // Is question locked?
        if(!$this->checkQuestionForLock($questionId))
        {
            if($this->getUser()->hasCredential('admin') || $user->getExperienceScore() >= sfConfig::get('app_experience_needed_edit_tags'))
            {
                $this->is_admin = true;
            }
            else
                $this->redirect404();

            if($request->isMethod('post'))
            {
                $tags = $request->getParameter('question_tags');

                if($this->validateTags($tags))
                {
                    $this->question->removeAllTags();
                    $this->question->addTag(preg_split('/\s+/', trim($tags)));
                    $this->question->save();

                    $this->redirect('@question_detail?question_title='.myUtil::createSlug($this->question->getTitle()).'&question_id='.$this->question->getId());
                }
            }
        }
        else
            $this->redirect('@question_detail?question_title='.myUtil::createSlug($this->question->getTitle()).'&question_id='.$this->question->getId());
    }

    public function executeEditOwnAnswer(sfWebRequest $request)
    {
        $answerId = $request->getParameter("answer_id");
        $save     = $request->getParameter("save");

        $this->answer = AnswerPeer::getByIdPk($answerId);
        $question = QuestionPeer::getByIdPk($this->answer->getQuestionId());

        if(!$this->checkQuestionForLock($question->getId()))
        {
            if(!$this->getUser()->hasCredential('admin'))
            {
                if($this->answer->getUserId() != $this->getUser()->getCurrentUser()->getId())
                    $this->redirect404();
            }

            if ($this->getRequest()->getMethod() == sfRequest::POST && $save)
            {
                $answer = $request->getParameter('answer');
                $this->answer->setAnswer($answer);
                $this->answer->save();

                $this->redirect('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId());
            }
        }
        else
            $this->redirect('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId());
    }

    public function validateEditOwnAnswer()
    {
        $save = $this->getRequest()->getParameter("save");

        if ($this->getRequest()->getMethod() == sfRequest::POST && $save)
        {
            if($this->getRequest()->hasErrors())
                return false;
            else return true;
        }
        else
            return true;
    }

    public function handleErrorEditOwnAnswer()
    {
        $answerId = $this->getRequest()->getParameter("answer_id");
        $this->answer = AnswerPeer::getByIdPk($answerId);
        return sfView::SUCCESS;
    }

    public function executeDeleteQuestion(sfWebRequest $request)
    {
        $questionId = $request->getParameter('question_id');

        $currentUserId = $this->getUser()->getCurrentUser()->getId();

        $question = QuestionPeer::getByIdPk($questionId);

        if(($currentUserId == $question->getUserId()) || $this->getUser()->hasCredential('admin'))
        {
            $question->softDelete();
        }

        $this->redirect('@homepage');
    }

    public function executeDeleteAnswer(sfWebRequest $request)
    {
        $answerId = $request->getParameter('answer_id');

        $answer = AnswerPeer::getByIdPk($answerId);

        $question = QuestionPeer::getByIdPk($answer->getQuestionId());

        $userId = $this->getUser()->getCurrentUser()->getId();

        if(($userId == $answer->getUserId() && !$this->checkQuestionForLock($question->getId())) || $this->getUser()->hasCredential('admin'))
        {
            $answer->setVisible(false);
            $answer->save();
        }
        $this->redirect("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId());
    }

    public function executeUndeleteQuestion(sfWebRequest $request)
    {
        $questionId = $request->getParameter('question_id');

        $question = QuestionPeer::getByIdPk($questionId, true);

        $question->setVisible(true);
        $question->save();

        $this->redirect("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId());
    }

    public function executeUndeletedAnswers(sfWebRequest $request)
    {
        $answerId = $request->getParameter('answer_id');

        $answer = AnswerPeer::getByIdPk($answerId, true);

        $answer->setVisible(true);
        $answer->save();

        $this->redirect("@deleted_answers");

    }

    public function executeLockQuestion(sfWebRequest $request)
    {
        $questionId = $request->getParameter('question_id');
        $lock_reason = $request->getParameter('question-lock-reason');

        if($questionId && $lock_reason)
        {
            $question = QuestionPeer::getByIdPk($questionId, true);
            $question->setLocked(true);

            // delete any old reasons for being locked
            QuestionClosedPeer::deleteExistingReason($questionId);

            $question_closed = new QuestionClosed();
            $question_closed->setReasonType($lock_reason);

            if($lock_reason == 'It is a duplicate question')
            {
                $question_closed->setReasonText($request->getParameter('question-lock-duplicate-id', 0));
            }

            $question->addQuestionClosed($question_closed);
            $originalDate = $question->getUpdatedAt();
            $question->save();

            $question->setUpdatedAt($originalDate);
            $question->save();
        }

        $this->redirect("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId());
    }

    public function executeUnlockQuestion(sfWebRequest $request)
    {
        $questionId = $request->getParameter('question_id');

        $question = QuestionPeer::getByIdPk($questionId, true);
        $question->setLocked(false);
        $originalDate = $question->getUpdatedAt();
        $question->save();

        $question->setUpdatedAt($originalDate);
        $question->save();

        $this->redirect("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId());
    }

    public function executeBuildSearchArray(sfWebRequest $request)
    {
        $array = array();

        
    }
    
    public function executeAutoLink(sfWebRequest $request)
    {
        $question = QuestionPeer::retrieveByPK(187);

        $content = strip_tags($question->getDescription());
        $content = fpSphinxClient::removeCommonTerms($content);
        $arrWords = explode(' ', $content);

        $arrWordCount = array();

        foreach ($arrWords as $word)
        {
              if (!array_key_exists($word, $arrWordCount))
              {
                    $arrWordCount[$word] = 0;
              }
              $arrWordCount[$word]++;
        }

//        arsort($arrWordCount);

//        var_dump($arrWordCount);

        $affiliates = array();

        foreach ($arrWordCount as $word => $num)
        {
            $affiliates[$word] = $this->getAffiliateLink($word);
        }
        var_dump($affiliates);
        exit;
    }

    private function getAffiliateLink($word)
    {
        $word = str_replace("'", "", $word);
        $affiliate = call_user_func_array(CJ::getCurrentTableName() . "::getLink", array($word));

        if(is_null($affiliate->getId()))
        {
            return false;
        }
        else
            return $affiliate->getBuyUrl();
    }

    public function setMetas($title, $description)
    {
        $cleaned_description = strip_tags($description);
        $cleaned_description = str_replace('&nbsp;', ' ', $cleaned_description);
        $cleaned_description = substr($cleaned_description, 0, 200);

        $this->getResponse()->setTitle($title . ' - ' . sfConfig::get('app_domain_url'));
        $this->getResponse()->addMeta('description', $cleaned_description);
    }

    public function executeDeleteComment(sfWebRequest $request)
    {
        $type = $request->getParameter('type');
        $comment_id = $request->getParameter('comment_id');

        $user = $this->getUser();

        if($type && $comment_id)
        {
            if($type == 'question')
            {
                $comment = QuestionCommentPeer::retrieveByPK($comment_id);
                $question = $comment->getQuestion();
            }

            if($type == 'answer')
            {
                $comment = AnswerCommentPeer::retrieveByPK($comment_id);
                $question = $comment->getAnswer()->getQuestion();
            }

            if($user->isAuthenticated() && $comment)
            {
                if($user->getCurrentUser()->getId() == $comment->getUserId() || $user->hasCredential('admin'))
                {
                    $comment->delete();
                }
            }
            else
                $this->redirect404();
        }
        else
            $this->redirect404();

        $this->redirect("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId());
    }

    private function validateTags($tags)
    {
        $valid = true;
        $expTags = explode(" ", trim($tags));

        if($expTags[0] == "")
        {
            $this->getRequest()->setError('question_tags', 'Please add at least one tag.');
            $valid = false;
        }
        
        if(count($expTags) > 5)
        {
            $this->getRequest()->setError('question_tags', 'Please only add up to 5 tags.');
            $valid = false;
        }

        $userId = $this->getUser()->getCurrentUser()->getId();

        // check if user can add new tags
        if(!fpExperience::checkForAction($userId, 'add_tags'))
        {
            $new_tags = $this->checkForNewTags($expTags);

            if($new_tags)
            {
                $new_tags = str_replace(' ', ', ', $new_tags);
                $this->getRequest()->setError('question_tags', "You don't have enough experience points to add the new tags: " . $new_tags);
                $valid = false;
            }
        }

        return $valid;
    }

    private function checkForNewTags($tags)
    {
        $new_tags = '';

        foreach($tags as $tag)
        {
            $tag_record = TagPeer::retrieveByTagname($tag);
            if(!$tag_record)
            {
                $new_tags .= $tag . ' ';
            }
        }

        if($new_tags == '')
            return false;
        else
            return trim($new_tags);
    }
}