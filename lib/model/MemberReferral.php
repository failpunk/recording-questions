<?php

class MemberReferral extends BaseMemberReferral
{
    public static function validateInput($params)
    {
        if($params['from'] == '' || is_null($params['from'])) {
            return 'You must specify who the invite is from.';
        }

        if(!self::validateEmail($params['email1'])) {
            return 'Invalid email address';
        }

        if($params['invite'] == '') {
            return 'The invite field can not be blank';
        }

        if(strlen($params['invite']) < 15) {
            return 'Please enter at least 15 characters in the invite field.';
        }

        return true;
    }


    public function sendEmail($message, $from)
    {
        $mail = new Mail();

        $subject = $from . ' has sent you an invite to Recording Questions';

        $mailMessage = $this->createReferralMessage($message);
        $mail->sendEmail($subject, $mailMessage, $this->getEmail());
    }


    private function createReferralMessage($userMessage)
    {
        sfProjectConfiguration::getActive()->loadHelpers("Url");

        $referralLink = url_for('@email_referral_link?userId=' . $this->getUserId() . '&hash=' . $this->getHash(), true);

        $link = '<a href="' . $referralLink . '">Take a look at Recording Questions now!</a>';

        return $userMessage . "<br><br>" . $link;
    }


    public static function getRemainingPoints($userId)
    {
        return MemberReferralPeer::getPointsByUser($userId);
    }


    private static function validateEmail($email)
    {
        $emailValidator = new sfValidatorEmail();

        try
        {
            $validEmail = $emailValidator->clean($email);
        }
        catch(sfValidatorError $e)
        {
            return false;
        }
        return true;
    }
}
