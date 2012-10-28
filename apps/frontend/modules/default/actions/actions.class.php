<?php

/**
 * default actions.
 *
 * @package    social
 * @subpackage default
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class defaultActions extends sfActions
{
  /**
   * Warning page for restricted area - requires login
   *
   */
  public function executeSecure()
  {
  }

  /**
   * Module disabled
   *
   */
  public function executeDisabled()
  {
  }

  /**
   * Static page
   *
   */
  public function executeSocial()
  {
  }

  /**
   * Static page
   *
   */
  public function executeTos()
  {
  }

  /**
   * Static page
   *
   */
  public function executeAbout()
  {
  }

  /**
   * Scheduler, process pending tasks of Social Lab's bots
   *
   */
  public function executeScheduler()
  {
    $log = "Starting scheduler...\n";
    $verbose = sfConfig::get('app_scheduler_logs'); // Set it to false for non-verbose logs
    $criteria = new Criteria();
    $criteria->add(ScheduledPeer::STATUS, sfConfig::get('app_status_pending'));
    $tasks = ScheduledPeer::doSelect($criteria);
    foreach($tasks as $task)
    {
      if ($verbose)
      {
        $log .= "Processing task ".$task->getId()."...\n";
      }
      $from = $task->getsfGuardUserProfileRelatedByFromId();
      $to = $task->getsfGuardUserProfileRelatedByToId();
      $isFriend = $from->isFriend($to);
      $isFriendOfFriends = $isFriend || $from->isFriendOfFriends($to);
      $criteria = new Criteria();
      $criteria->add(BotPeer::USER_ID, $task->getFromId());
      $bots = BotPeer::doSelect($criteria);
      $bot = $bots[0];
      $criteria = new Criteria();
      $criteria->add(StepPeer::STEP_ORDER, $task->getStep(), Criteria::GREATER_EQUAL);
      $steps = $bot->getSteps($criteria);
      $donotcontinue = false;
      foreach ($steps as $step)
      {
        if ($verbose)
        {
          $log .= "Task ".$task->getId().", step ".$step->getStepOrder().": ".$step->getCommand()."\n";
        }
        switch ($step->getCommandId())
        {
          case sfConfig::get('app_command_systemmsg'):
            $automsg = $step->getAutomsg();
            $text = $automsg->getText();
            $profile = $automsg->getsfGuardUserProfile();
            if ($profile)
            {
              $link = '<a href="/profile/show/?id='.$profile->getId().'">'.$profile.'</a>';
              $text = sprintf($text, $link);
            }
            Social::sendMessage(sfConfig::get('app_system_id'), $task->getToId(), $text, false);
            $task->setStep($task->getStep() + 1);
            break;
          case sfConfig::get('app_command_sendmsg'):
            $automsg = $step->getAutomsg();
            $text = $automsg->getText();
            $profile = $automsg->getsfGuardUserProfile();
            if ($profile)
            {
              $link = '<a href="/profile/show/?id='.$profile->getId().'">'.$profile.'</a>';
              $text = sprintf($text, $link);
            }
            Social::sendMessage($task->getFromId(), $task->getToId(), $text, false);
            $task->setStep($task->getStep() + 1);
            break;
          case sfConfig::get('app_command_sendwall'):
            if ($isFriend)
            {
              $automsg = $step->getAutomsg();
              $text = $automsg->getText();
              $profile = $automsg->getsfGuardUserProfile();
              if ($profile)
              {
                $link = '<a href="/profile/show/?id='.$profile->getId().'">'.$profile.'</a>';
                $text = sprintf($text, $link);
              }
              Social::sendMessage($task->getFromId(), $task->getToId(), $text, true);
              $task->setStep($task->getStep() + 1);
            }
            break;
          case sfConfig::get('app_command_tagfriend'):
            if ($isFriend)
            {
              $criteria = new Criteria();
              $criteria->add(TagPeer::USER_ID, $to->getId());
              foreach ($from->getPictures() as $pic)
              {
                if (!$pic->getTags($criteria))
                {
                  Social::tag($to->getId(),$pic->getId());
                }
              }
              $task->setStep($task->getStep() + 1);
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_accept'):
            if (!$isFriend) 
            {
              $friendship = new Friendship();
              $friendship->setUser1Id($task->getFromId());
              $friendship->setUser2Id($task->getToId());
              $friendship->save();
            }
            $criteria = new Criteria();
            $criteria->add(RequestPeer::FROM_ID, $task->getToId());
            $criteria->add(RequestPeer::TO_ID, $task->getFromId());
            $requests = RequestPeer::doSelect($criteria);
            if (!empty($requests))
            {
              $request = $requests[0];
              $request->setStatus(sfConfig::get('app_status_accepted'));
              $request->save();
            }
            $task->setStep($task->getStep() + 1);
            break;
          case sfConfig::get('app_command_checklocation'):
            $canSee = ($to->getLocationInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($to->getLocationInfoIsPublic() == sfConfig::get('app_privacy_fof') && $isFriendOfFriends) || ($to->getLocationInfoIsPublic() == sfConfig::get('app_privacy_friends') && $isFriend);
            if ($canSee)
            {
              if ($from->getLocationTown() == $to->getLocationTown())
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkacademic'):
            $canSee = ($to->getAcademicInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($to->getAcademicInfoIsPublic() == sfConfig::get('app_privacy_fof') && $isFriendOfFriends) || ($to->getAcademicInfoIsPublic() == sfConfig::get('app_privacy_friends') && $isFriend);
            if ($canSee)
            {
              if (stristr($to->getAcademicCenter(), $from->getAcademicCenter()))
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkrequest'):
            $criteria = new Criteria();
            $criteria->add(RequestPeer::FROM_ID, $task->getToId());
            $criteria->add(RequestPeer::TO_ID, $task->getFromId());
            $requests = RequestPeer::doSelect($criteria);
            if (!empty($requests))
            {
              $request = $requests[0];
              if (stristr($request->getText(), $step->getAutomsg()->getText()))
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkfof'):
            if ($to->isFriendOfFriends($from))
            {
              $task->setStep($task->getStep() + 1);
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkfriendtagged'):
            $canSee = ($to->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($to->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $isFriendOfFriends) || ($to->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $isFriend);
            if ($canSee)
            {
              $criteria = new Criteria();
              $subSelect1 = "tag.USER_ID IN (SELECT friendship.USER2_ID FROM friendship WHERE friendship.USER1_ID = ".$from->getId().")";
              $subSelect2 = "tag.USER_ID IN (SELECT friendship.USER1_ID FROM friendship WHERE friendship.USER2_ID = ".$from->getId().")";
              $crit1 = $criteria->getNewCriterion(TagPeer::USER_ID, $subSelect1, Criteria::CUSTOM);
              $crit2 = $criteria->getNewCriterion(TagPeer::USER_ID, $subSelect2, Criteria::CUSTOM);
              $crit1->addOr($crit2); 
              $criteria->add($crit1);
              $criteria->add(PicturePeer::OWNER_ID, $to->getId());
              $tags = TagPeer::doSelectJoinPicture($criteria);
              if (!empty($tags))
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkpage'):
            $canSee = ($to->getPagesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($to->getPagesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $isFriendOfFriends) || ($to->getPagesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $isFriend);
            if ($canSee)
            {
              $criteria = new Criteria();
              $subSelect1 = "fan.PAGE_ID IN (SELECT fan.PAGE_ID FROM fan WHERE fan.USER_ID = ".$to->getId().")";
              $criteria->add(FanPeer::PAGE_ID, $subSelect1, Criteria::CUSTOM);
              $criteria->add(FanPeer::USER_ID, $from->getId());
              $fans = FanPeer::doCount($criteria);
              if ($fans > 0)
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkpageowner'):
            $canSee = ($to->getPagesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($to->getPagesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $isFriendOfFriends) || ($to->getPagesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $isFriend);
            if ($canSee)
            {
              $criteria = new Criteria();
              $subSelect1 = "fan.PAGE_ID IN (SELECT fan.PAGE_ID FROM fan WHERE fan.USER_ID = ".$to->getId().")";
              $criteria->add(FanPeer::PAGE_ID, $subSelect1, Criteria::CUSTOM);
              $criteria->add(PagePeer::OWNER_ID, $from->getId());
              $fans = FanPeer::doSelectJoinPage($criteria);
              if (!empty($fans))
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checktaggedbyfriend'):
            $canSee = ($to->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($to->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $isFriendOfFriends) || ($to->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $isFriend);
            if ($canSee)
            {
              $criteria = new Criteria();
              $subSelect1 = "picture.OWNER_ID IN (SELECT friendship.USER2_ID FROM friendship WHERE friendship.USER1_ID = ".$from->getId().")";
              $subSelect2 = "picture.OWNER_ID IN (SELECT friendship.USER1_ID FROM friendship WHERE friendship.USER2_ID = ".$from->getId().")";
              $crit1 = $criteria->getNewCriterion(PicturePeer::OWNER_ID, $subSelect1, Criteria::CUSTOM);
              $crit2 = $criteria->getNewCriterion(PicturePeer::OWNER_ID, $subSelect2, Criteria::CUSTOM);
              $crit1->addOr($crit2); 
              $criteria->add($crit1);
              $criteria->add(TagPeer::USER_ID, $to->getId());
              $tags = TagPeer::doSelectJoinPicture($criteria);
              if (!empty($tags))
              {
                $task->setStep($task->getStep() + 1);
              }
              else
              {
                $donotcontinue = true;
              }
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkfotwof'):
            $friends = $from->getFriendsProfiles();
            $fof = 0;
            foreach ($friends as $friend) 
            {
              if ($friend->isFriend($to)) 
              {
                $fof++;
              }
            }
            if ($fof > 1)
            {
              $task->setStep($task->getStep() + 1);
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          case sfConfig::get('app_command_checkfriendwall'):
            $criteria = new Criteria();
            $subSelect1 = "message.TO_ID IN (SELECT friendship.USER2_ID FROM friendship WHERE friendship.USER1_ID = ".$from->getId().")";
            $subSelect2 = "message.TO_ID IN (SELECT friendship.USER1_ID FROM friendship WHERE friendship.USER2_ID = ".$from->getId().")";
            $crit1 = $criteria->getNewCriterion(MessagePeer::TO_ID, $subSelect1, Criteria::CUSTOM);
            $crit2 = $criteria->getNewCriterion(MessagePeer::TO_ID, $subSelect2, Criteria::CUSTOM);
            $crit1->addOr($crit2); 
            $criteria->add($crit1);
            $criteria->add(MessagePeer::FROM_ID, $to->getId());
            $criteria->add(MessagePeer::IS_PUBLIC, true);
            $criteria->add(MessagePeer::TEXT, '%'.$step->getAutomsg()->getText().'%', Criteria::LIKE);
            $criteria->setIgnoreCase(true);
            if (MessagePeer::doCount($criteria) > 0)
            {
              $task->setStep($task->getStep() + 1);
            }
            else
            {
              $donotcontinue = true;
            }
            break;
          default:
            if ($verbose)
            {
              $log .= "Task ".$task->getId()." error: command unknown ;-(\n";
            }
        }
        if($donotcontinue)
        {
          break; // Condition not met, don't continue with the next step
        }
      }
      if ($task->getStep() == $bot->countSteps())
      {
        $task->setStatus(sfConfig::get('app_status_accepted'));
      }
      $task->save();
      if ($verbose)
      {
        $log .= "Task ".$task->getId()." finished.\n";
      }
    }
    $log .= "Finished!\n";
    $this->log = $log;
  }
}
