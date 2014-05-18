<?php

class profileComponents extends sfComponents
{
    public function executeUserProfile(sfWebRequest $request)
    {
       $this->age = myUtil::nicetime($this->currentUser->getBirthday());

       $this->userRank = UserPeer::getRank($this->currentUser->getId());

       $this->profile_views = ProfileViewsPeer::getViewCount($this->currentUser->getId());
    }

    public function executeUserPosts(sfWebRequest $request)
    {
       if(!$this->page) {
           $this->page = 1;
       }

       if($this->type == 'question')
            $this->userPosts = QuestionPeer::getByUser($this->userId, $this->page);
       elseif ($this->type == 'answer') 
            $this->userPosts = AnswerPeer::getByUser($this->userId, $this->page);

       if($this->getUser()->getCurrentUser()->getId() == $this->userId)
            $this->thisUser = true;
        else
            $this->thisUser = false;
    }

    public function executeUserComments(sfWebRequest $request)
    {
       if(!$this->page) {
           $this->page = 1;
       }

        $this->questionComments = QuestionCommentPeer::getActive($this->userId);
        $this->answerComments = AnswerCommentPeer::getActive($this->userId);

        $this->commentCount = count($this->answerComments) + count($this->questionComments);

        if($this->getUser()->getCurrentUser()->getId() == $this->userId)
            $this->thisUser = true;
        else
            $this->thisUser = false;
    }

    public function executeAddTwitter(sfWebRequest $request)
    {
        $twitter = new TwitterUser($this->user->getId());

        // show twitter account fields if not yet added
        if($twitter->getUserName()) {
            $this->edit_account = 'none';
        } else {
            $this->edit_account = 'block';
        }

        $this->twitter = $twitter;
    }
}
?>