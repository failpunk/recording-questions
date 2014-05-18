<?php
class fpExpAnswerControlHandler extends fpSpamControlHandler
{
   private $obj;

    public function init($args)
    {
        $this->obj = $args[0];
    }

    public function execute()
    {
        $userId = $this->obj->getUserId();

        fpExperience::updateNegativeForUser($userId, "unset_user_best_answer");
        fpExperience::updateNegativeForUser($this->getCurrentUser()->getId(), "unset_best_answer");
    }


}