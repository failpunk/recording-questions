<?php

class MemberReferralPeer extends BaseMemberReferralPeer
{
    static public function emailAlreadySent($email, $userId)
    {
        $result = DbFinder::from('MemberReferral')
                    ->where('email', $email)
                    ->where('userId', $userId)
                    ->count();

        if($result > 0)
            return true;
        else
            return false;
    }

    static public function getByHash($userId, $hash)
    {
        return DbFinder::from('MemberReferral')
                    ->where('hash', $hash)
                    ->where('userId', $userId)
                    ->findOne();
    }

    static public function getWeekelyEmailCount($userId)
    {
        return DbFinder::from('MemberReferral')
                    ->where('userId', $userId)
                    ->where('CreatedAt', '>=', strtotime('last '. sfConfig::get('app_referral_contest_day')))
                    ->count();
    }

    static public function getPointsByUser($userId)
    {
        return DbFinder::from('MemberReferral')
                    ->where('userId', $userId)
                    ->where('active', 0)
                    ->count();
    }

    static public function getReferralCount($userId)
    {
        return DbFinder::from('MemberReferral')
                    ->where('userId', $userId)
                    ->where('newMember', 1)
                    ->count();

    }
}
