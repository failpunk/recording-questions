<?php

class fpExperienceBestAnswerControlHandler extends fpSpamControlHandler
{
    private $obj;

    public function init($args)
    {
        $this->obj = $args[0];
    }

    public function execute()
    {
        $userId = $this->obj->getUserId();

        fpExperience::updatePositiveForUser($userId, "best_answer");
        fpExperience::updatePositiveForUser($this->getCurrentUser()->getId(), "select_best_answer");
    }

}