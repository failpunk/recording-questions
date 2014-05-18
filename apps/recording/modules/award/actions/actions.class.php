<?php

/**
 * award actions.
 *
 * @package    recording
 * @subpackage award
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class awardActions extends sfActions
{
    static $award_count;
 /**
  * Executes awards action
  *
  * @param sfRequest $request A request object
  */
  public function executeAwards(sfWebRequest $request)
  {
      $this->awards = AwardPeer::getAllAwards();

      $user = $this->getUser()->getCurrentUser();
      $this->awarded = UserAwardPeer::getAwardsForUser($user->getId());
      self::$award_count = UserAwardPeer::getAwardsCount();
  }

  /**
   * This static funtion is used by the view to access the static award count array.  Pass in the
   * award id and it will return the count if found, otherwise 0.
   * @param int $awardId    The id of the award.
   * @return int            The number of times the id was awarded.
   */
  public static function getAwardCount($awardId)
  {
      if(array_key_exists($awardId, self::$award_count)) {
          return self::$award_count[$awardId];
      } else {
          return 0;
      }
  }
}
