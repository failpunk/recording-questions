<?php

class Mail
{
    private $_connection;
    private $_inactiveDate;

    private $_emailCount = 0;

    function __construct()
	{
        // Create the mailer and message objects
        $this->_connection = new Swift_Connection_SMTP('smtp.gmail.com', 465, Swift_Connection_SMTP::ENC_SSL);
	}

	public function sendUpdateEmail($userId = false)
	{
        // get users who have not logged in for 7 days
        $this->_inactiveDate = date('Y-m-d h:i:s', time() - (86400 * 7));

        if($userId)
            $inactiveUsers = UserPeer::retrieveByPKs($userId);
        else
            $inactiveUsers = UserPeer::getInactiveUsers($this->_inactiveDate);

        foreach ($inactiveUsers as $user) 
        {   
            // make sure email notifications are on and we haven't mailed them in past 7 days
            if($user->getEmailOn() && $user->getLastEmail() < $this->_inactiveDate)
            {
                $mailBody = $this->constructUpdateMessage($user);

                if($mailBody) {
                    $this->sendMail('Recording Questions Activity Report', $mailBody, $user->getEmail());

                    // log when email was sent
                    $user->setLastEmail(date('Y-m-d h:i:s'));
                    $user->save();

                    // Tally for process log
                    $this->_emailCount++;

                    echo "Mail sent to: " . $user->getEmail() . "\n";
                }
            }
        }

        // log number of emails sent
        ProcessLogPeer::addLog('updateEmails', "Sent $this->_emailCount update emails to members");
	}

    private function constructUpdateMessage(User $user)
    {
        // for now, grab any user messages they have and us that for update
        $messages = UserMessagePeer::getMessagesForUser($user->getId());

        if(count($messages) <= 5)
        {
            $questions = QuestionPeer::getRecentQuestion(1, 5)->getResults();
        }
        else
            $questions = false;

        //justin: REMOVE THIS when done testing in browser!
        sfProjectConfiguration::getActive()->loadHelpers("Partial");

        $mailBody = get_Partial('mail/updateEmail', array('messages' => $messages, 'questions' => $questions));
        return $mailBody;
    }

    private function sendMail($subject, $mailBody, $to)
    {
        try
        {
          $mailer = new Swift($this->_connection);
          $message = new Swift_Message($subject);

          // Render message parts
          $message->attach(new Swift_Message_Part($mailBody, 'text/html'));
          $message->attach(new Swift_Message_Part($mailBody, 'text/plain'));

          // Send
          $mailer->send($message, $to, new Swift_Address(sfConfig::get('app_email_from'), "Recording Questions"));
          $mailer->disconnect();
        }
        catch (Exception $e)
        {
          $mailer->disconnect();
        }
    }

    public function sendEmail($subject, $mailBody, $to)
    {
        try
        {
          // Create the mailer and message objects
          $mailer = new Swift($this->_connection);
          $message = new Swift_Message($subject, $mailBody, 'text/html');

          // Send
          $mailer->send($message, $to, new Swift_Address(sfConfig::get('app_email_from'), "Recording Questions"));
          $mailer->disconnect();
        }
        catch (Exception $e)
        {
          $mailer->disconnect();
          // handle errors here
        }
    }

    public function sendTextEmail($subject, $mailBody, $to)
    {
        try
        {
          // Create the mailer and message objects
          $mailer = new Swift($this->_connection);
          $message = new Swift_Message($subject, $mailBody);

          // Send
          $mailer->send($message, $to, new Swift_Address(sfConfig::get('app_email_from'), "Recording Questions"));
          $mailer->disconnect();
        }
        catch (Exception $e)
        {
          $mailer->disconnect();
          // handle errors here
        }
    }

    public function sendNotificationEmail($questionId, $type, $data)
	{
        if($questionId && $type)
        {
            if($type == 'answer')
            {
                $this->sendAnswerNotification($questionId, $data);
            }

            if($type == 'comment')
            {
                $this->sendCommentNotification($questionId, $data);
            }
        }
    }

    private function sendAnswerNotification($questionId, Answer $answer)
    {
        $question = QuestionPeer::retrieveByPK($questionId);

        if($question)
        {
            // don't send notification emails to yourself
            if($question->getUserId() == $answer->getUserId()) {
                return false;
            }

            if($question->getNotifyEmail() == '' || is_null($question->getNotifyEmail())) {
                return false;
            }

            sfProjectConfiguration::getActive()->loadHelpers("Partial");
            $mailBody = get_Partial('mail/emailNewAnswer', array('answer' => $answer, 'question' => $question));
            if($mailBody) {
                $this->sendMail('Recording Questions - New Answer', $mailBody, $question->getNotifyEmail());
            }
        }
    }

    /**
     * Notifies the owner of the question and the owner of the answer via email if someone leaves a comment.
     * 
     * @param <type> $questionId
     * @param <type> $comment
     * @return <type> 
     */
    private function sendCommentNotification($questionId, $comment)
    {
        $question = QuestionPeer::retrieveByPK($questionId);

        if($question)
        {
            // don't send notification emails to yourself
            if($question->getUserId() == $comment->getUserId()) {
                return false;
            }
            
            // only send email if user requested we do so when they asked the question
            if($question->getNotifyEmail() == '' || is_null($question->getNotifyEmail())) {
                return false;
            }

            // send new comment to question owner
            sfProjectConfiguration::getActive()->loadHelpers("Partial");
            $mailBody = get_Partial('mail/emailNewComment', array('comment' => $comment, 'question' => $question));

            if($mailBody) {
                $this->sendMail('Recording Questions - New Comment', $mailBody, $question->getNotifyEmail());
            }

            // send email to owner of answer as well if comment is for their answer
            if($comment instanceof AnswerComment)
            {
                $mailBody = get_Partial('mail/emailNewComment', array('comment' => $comment, 'question' => $question, 'answer' => true));
                if($mailBody)
                {
                    $answerEmail = $comment->getAnswer()->getUser()->getEmail();
                    $this->sendMail('Recording Questions - New Comment', $mailBody, $answerEmail);
                }
            }
        }
    }

    /**
     * Sends an email with a basic breakdown of what happended over the past day
     */
    public function sendSystemStatusEmail()
	{
        $from = date('Y-m-d h:i:s', time() - 86400);
        $to = date('Y-m-d h:i:s');
        
        $mailBody = '';

        // add yesterdays logs from process_log
        $logs = ProcessLogPeer::getYesterdaysLogs();
        foreach($logs as $log)
        {
            $mailBody .= $log->getDescription() . "<br>";
        }

        // New users
        $newUsers = UserPeer::getCountBetweenDates($from, $to);
        $mailBody .= "$newUsers new users signed up yesterday.<br>";

        // New questions
        $newQuestions = QuestionPeer::getCountBetweenDates($from, $to);
        $mailBody .= "$newQuestions new questions asked yesterday.<br>";
        
        // New answers
        $newAnswers = AnswerPeer::getCountBetweenDates($from, $to);
        $mailBody .= "$newAnswers new answers given yesterday.<br>";

        // Upvotes Cast
        $answerUpvotes = QuestionVotePeer::getCountBetweenDates($from, $to, 'upvote');
        $questionUpvotes = AnswerVotePeer::getCountBetweenDates($from, $to, 'upvote');
        $upvotes = $answerUpvotes + $questionUpvotes;
        $mailBody .= "$upvotes upvotes were given yesterday.<br>";

        // Downvotes Cast
        $answerDownvotes = QuestionVotePeer::getCountBetweenDates($from, $to, 'downvote');
        $questionDownvotes = AnswerVotePeer::getCountBetweenDates($from, $to, 'downvote');
        $downvotes = $answerDownvotes + $questionDownvotes;
        $mailBody .= "$downvotes downvotes were given yesterday.<br>";

        // Marked offensive
        $offensiveQuestions = QuestionOffensivePeer::getBetweenDates($from, $to);
        $offensiveAnswers = AnswerOffensivePeer::getBetweenDates($from, $to);

        foreach($offensiveQuestions as $question) {
            $mailBody .= "QuestionId $question->getId() was marked offensive $question->getColumn('count') times yesterday.<br>";
        }
        
        foreach($offensiveAnswers as $answer) {
            $mailBody .= "AnswerId ". $answer->getId() . " was marked offensive " . $answer->getColumn('count') . " times yesterday.<br>";
        }

        // New Pages Added
        $gearAdded = RecentActivityPeer::getBetweenDates($from, $to, 'created');
        $mailBody .= "$gearAdded new pages were added to the gear database yesterday.<br>";

        // Pages Updated
        $gearUpdated = RecentActivityPeer::getBetweenDates($from, $to, 'updated');
        $mailBody .= "$gearUpdated pages were updated in the gear database yesterday.<br>";

        // Images addd or Updated
        $imagesChanged = RecentActivityPeer::getBetweenDates($from, $to, 'updated the image for');
        $mailBody .= "$imagesChanged images were updated in the gear database yesterday.<br>";

        // Gear added to studio
        $studioGear = RecentActivityPeer::getBetweenDates($from, $to, 'owns');
        $mailBody .= "$studioGear pieces of gear added to member studios yesterday.<br>";

        $recipients = new Swift_RecipientList();
        $recipients->addTo('erin@recordingquestions.com');

        $this->sendMail('Recording Questions - Daily System Update', $mailBody, $recipients);
    }
}
