<?php

class QuestionPeer extends BaseQuestionPeer
{
    public function updateVisited($questionId)
    {
        $con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
        //TODO only update visited once per ip, per day.
        $selc = new Criteria();
        $selc->add(QuestionPeer::ID, $questionId);

        $updc = new Criteria();
        $updc->add(QuestionPeer::VISITED, array('raw' =>  QuestionPeer::VISITED. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);

        BasePeer::doUpdate($selc, $updc, $con);
    }

    static function getCountAnswers($currentPage, $maxResultsPerPage)
    {
        $query = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->leftJoin('User')
                ->with('User', 'Answer')
                ->withColumn('count(Answer.questionId)', 'total_answer')
                ->where('Question.Visible', true)
                ->where('Answer.Visible', true)
                ->orderBy('updatedAt', 'desc')
                ->groupBy('Question.Id');

        $result = $query->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    static function getRecentQuestion($currentPage, $maxResultsPerPage)
    {
        $query = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->where('Question.Visible', true)
                ->orderBy('updatedAt', 'desc')
                ->groupBy('Question.Id');

        $result = $query->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    static function getPopularQuestion($currentPage, $maxResultsPerPage)
    {
        $finder = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->withColumn('(Question.upvotes - Question.downvotes)', 'total_vote')
                ->where('Question.Visible', true)
                ->groupBy('Question.Id');

        $criteria = $finder->getQueryObject();
        $criteria->addDescendingOrderByColumn('total_vote');
        $result = $finder->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    static function getLastWeekQuestion($currentPage, $maxResultsPerPage)
    {
        $lastWeek = time() - 604800;
        $result = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->where('Question.Visible', true)
                ->where('CreatedAt', '>', $lastWeek)
                ->groupBy('Question.Id')
                ->orderBy('updatedAt', 'desc')
                ->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    static function getLastMonthQuestion($currentPage, $maxResultsPerPage)
    {
        $lastMonth = time() - 2592000;
        $result = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->where('CreatedAt', '>', $lastMonth)
                ->where('Question.Visible', true)
                ->groupBy('Question.Id')
                ->orderBy('updatedAt', 'desc')
                ->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    static function getUnansweredQuestion($currentPage, $maxResultsPerPage)
    {
        $result = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->where('Answer.questionId', 'is NULL')
                ->where('Question.Visible', true)
                ->groupBy('Question.Id')
                ->orderBy('updatedAt', 'desc')
                ->paginate($currentPage, $maxResultsPerPage);

        return $result;
    }

    static public function getFavoriteQuestion($currentPage, $maxResultsPerPage, $userId)
    {
        $result = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->leftJoin('Question.userId', 'User.Id')
                ->leftJoin('UserFavorite')
                ->where('UserFavorite.userId', $userId)
                ->where('Question.Visible', true)
                ->orderBy('createdAt', 'desc')
                ->groupBy('Answer.questionId')
                ->paginate($currentPage, $maxResultsPerPage);

        return $result;
    }

    public function updateOffensiveQuestion($questionId)
    {
        $con = Propel::getConnection(QuestionPeer::DATABASE_NAME);

        $selc = new Criteria();
        $selc->add(QuestionPeer::ID, $questionId);

        $updc = new Criteria();
        $updc->add(QuestionPeer::OFFENSIVE, array('raw' =>  QuestionPeer::OFFENSIVE. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);

        BasePeer::doUpdate($selc, $updc, $con);
    }

    public static function retrieveByPKsExtended($pks)
    {
        $objs = null;
        if (empty($pks))
        {
            $objs = array();
        } else
        {
            $finder = DbFinder::from('Question')
                    ->leftJoin('Answer')
                    ->leftJoin('User')
                    ->with('User')
                    ->withColumn('count(Answer.questionId)', 'total_answer')

                    ->where('Question.Visible', true)
                    ->groupBy('Question.Id');

            $criteria = $finder->getQueryObject();
            $criteria->add(QuestionPeer::ID, $pks, Criteria::IN);

            $objs = $finder->find();


        }
        return $objs;
    }

    public static function retrieveByPKsExtendedByNewest($pks)
    {
        $objs = null;
        if (empty($pks))
        {
            $objs = array();
        } else
        {
            $finder = DbFinder::from('Question')
                    ->leftJoin('Answer')
                    ->leftJoin('User')
                    ->with('User')
                    ->withColumn('count(Answer.questionId)', 'total_answer')
                    ->where('Question.Visible', true)

                    ->orderBy('CreatedAt', 'desc')
                    ->groupBy('Question.Id');


            $criteria = $finder->getQueryObject();
            $criteria->add(QuestionPeer::ID, $pks, Criteria::IN);

            $objs = $finder->find();


        }
        return $objs;
    }

    public static function retrieveByPKsExtendedByMostVotes($pks)
    {
        $objs = null;
        if (empty($pks))
        {
            $objs = array();
        } else
        {
            $finder = DbFinder::from('Question')
                    ->leftJoin('Answer')
                    ->leftJoin('User')
                    ->with('User')
                    ->withColumn('count(Answer.questionId)', 'total_answer')
                    ->withColumn('(Question.upvotes - Question.downvotes)', 'total_vote')
                    ->where('Question.Visible', true)

                    ->groupBy('Question.Id');

            $criteria = $finder->getQueryObject();
            $criteria->addDescendingOrderByColumn('total_vote');

            $criteria->add(QuestionPeer::ID, $pks, Criteria::IN);

            $objs = $finder->find();


        }
        return $objs;
    }

    public static function retrieveByPKsExtendedByMostActive($pks)
    {
        $objs = null;
        if (empty($pks))
        {
            $objs = array();
        } else
        {
            $finder = DbFinder::from('Question')
                    ->leftJoin('Answer')
                    ->leftJoin('User')
                    ->with('User')
                    ->withColumn('count(Answer.questionId)', 'total_answer')
                    ->withColumn('(Question.upvotes - Question.downvotes)', 'total_vote')
                    ->where('Question.Visible', true)

                    ->orderBy('Visited', 'desc')
                    ->groupBy('Question.Id');

            $criteria = $finder->getQueryObject();
            $criteria->add(QuestionPeer::ID, $pks, Criteria::IN);

            $objs = $finder->find();


        }
        return $objs;
    }

    public static function countByUser($userId, $timeInterval)
    {
        return DbFinder::from('Question')
                ->where('userId', $userId)
                ->where('createdAt', '>', time() - $timeInterval)
                ->where('Question.Visible', true)

                ->count();
    }

    public static function getFavoriteQuestionByUser($questionId, $userId)
    {
        return DbFinder::from('UserFavorite')
                ->where('questionId',$questionId)
                ->where('userId', $userId)
                ->where('Question.Visible', true)

                ->findOne();
    }

    public static function updateVote($questionId, $state, $reverse = false)
    {
        $con = Propel::getConnection(QuestionPeer::DATABASE_NAME);

        $selc = new Criteria();
        $selc->add(QuestionPeer::ID, $questionId);

        $updc = new Criteria();

        if(!$reverse)
        {
            if($state)
                $updc->add(QuestionPeer::UPVOTES, array('raw' =>  QuestionPeer::UPVOTES. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
            else
                $updc->add(QuestionPeer::DOWNVOTES, array('raw' =>  QuestionPeer::DOWNVOTES. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
        }
        else
        {
            if($state)
                $updc->add(QuestionPeer::UPVOTES, array('raw' =>  QuestionPeer::UPVOTES. ' - ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
            else
                $updc->add(QuestionPeer::DOWNVOTES, array('raw' =>  QuestionPeer::DOWNVOTES. ' - ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
        }
        BasePeer::doUpdate($selc, $updc, $con);

        $questionPeer = QuestionPeer::retrieveByPK($questionId);
        $questionPeer->reload();

        return $questionPeer->getUpvotes() - $questionPeer->getDownvotes();
    }

    public function getTotalVotes()
    {
        return $this->getUpvotes() - $this->getDownvotes();
    }

    public static function getByUser($userId, $page = '', $perPage = 10)
    {
        $query = DbFinder::from("Question")
                ->where('userId', $userId)
                ->where('Question.Visible', true);

        if($page)
        {

            return $query->paginate($page, $perPage);
        }
        else
            return $query->find();
    }

    public static function getByIdPKs($questionId, $currentPage = '', $maxResultsPerPage = 15)
    {

        $result = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->withColumn('sum(Answer.Visible)', 'total_answer')
                ->withColumn('sum(Answer.Bestanswer)', 'best_answer')
                ->where('Question.Id', 'in', $questionId)
                ->where('Question.Visible', true)
                ->orderBy('updatedAt', 'desc')
                ->groupBy('Question.Id')
                ->paginate($currentPage, $maxResultsPerPage);

        return $result;
    }

    public static function getByIdPk($questionId, $isAdmin = false)
    {
        $query = DbFinder::from('Question')
                ->where('id', $questionId);
        if(!$isAdmin)
            $query->where('Question.Visible', true);

        return $query->findOne();
    }

    public static function getDeleteQuestion($currentPage, $maxResultsPerPage)
    {
        $query = DbFinder::from('Question')
                ->leftJoin('Answer')
                ->leftJoin('User')
                ->with('User', 'Answer')
                ->withColumn('count(Answer.questionId)', 'total_answer')

                ->where('Question.Visible', false)
                ->orderBy('updatedAt', 'desc')
                ->groupBy('Question.Id');

        $result = $query->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    public static function checkForLock($questionId)
    {
        $question = self::retrieveByPK($questionId);

        if($question)
        {
            if($question->getLocked())
                return true;
            else
                return false;
        }
    }

    public static function getQuestionsForSitemap($limit = 0, $offset = 0)
    {
        $questions = DbFinder::from('Question')
                ->where('Visible', true)
                ->orderBy('Upvotes', 'desc')
                ->select(array('Id', 'Title', 'Upvotes', 'Downvotes', 'UpdatedAt'))
                ->limit($limit)
                ->offset($offset)
                ->find();

        return $questions;
    }

    static function getCountQuestions()
    {
        return DbFinder::from('Question')->count();
    }

    static function getLowestVoteCount()
    {
        $result = DbFinder::from('Question')
                ->withColumn('MAX(Downvotes)', 'minvotes')
                ->where('Visible', true)
                ->select(array('Id'))
                ->find();
        return $result[0]['minvotes'];
    }

    static function getHighestVoteCount()
    {
        $result = DbFinder::from('Question')
                ->withColumn('MAX(Upvotes)', 'maxvotes')
                ->where('Visible', true)
                ->select(array('Id'))
                ->find();
        return $result[0]['maxvotes'];
    }

    static public function getCountBetweenDates($from, $to)
    {
        if(!$from)
        {
            $from = '2009-01-01 00:00:00';
        }

        if(!$from)
        {
            $to = '2099-01-01 00:00:00';
        }

        return DbFinder::from('Question')
                ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                ->count();
    }

    static public function getUntweetedQuestions()
    {
        return DbFinder::from('Question')
                ->where('Tweeted', 0)
                ->where('Visible', true)
                ->find();
    }
}
