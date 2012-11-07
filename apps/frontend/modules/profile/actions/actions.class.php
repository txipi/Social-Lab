<?php

/**
 * profile actions.
 *
 * @package    social
 * @subpackage profile
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class profileActions extends sfActions
{
  public function executeFriends(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    $this->forward404Unless($this->sfGuardUserProfile);
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $this->sfGuardUserProfiles = new sfPropelPager('sfGuardUserProfile', sfConfig::get('app_max_friends_per_page'));
      $this->sfGuardUserProfiles->setCriteria($this->getUser()->getProfile()->getFriendsProfilesCriteria());
      $this->sfGuardUserProfiles->setPage($request->getParameter('page', 1));
      $this->sfGuardUserProfiles->init();
    }
  }

  public function executeSearchfriends(sfWebRequest $request)
  {
    $this->profile = $this->getUser()->getProfile();
    $this->forward404Unless($this->profile);
    if ($this->profile->getFirstName() === '' || $this->profile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->profile->getId());
    } else {
      $criteria = new Criteria();
      $criteria->add(sfGuardUserProfilePeer::USER_ID, array($this->getUser()->getProfile()->getId(), sfConfig::get('app_system_id')), Criteria::NOT_IN);
      $criteria->addAscendingOrderByColumn(sfGuardUserProfilePeer::LAST_NAME);
      $criteria->addAscendingOrderByColumn(sfGuardUserProfilePeer::FIRST_NAME);
      $this->sfGuardUserProfiles = new sfPropelPager('sfGuardUserProfile', sfConfig::get('app_max_friends_per_page'));
      $this->sfGuardUserProfiles->setCriteria($criteria);
      $this->sfGuardUserProfiles->setPage($request->getParameter('page', 1));
      $this->sfGuardUserProfiles->init();
    }
  }

  public function executeWall(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    $this->forward404Unless($this->sfGuardUserProfile);
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $message = new Message();
      $message->setFromId($this->sfGuardUserProfile->getId());
      $message->setToId($this->sfGuardUserProfile->getId());
      $message->setIsPublic(true);
      $message->setIsUnread(false);
      $this->form = new MessageForm($message);
      $schema = $this->form->getWidgetSchema();
      $schema['from_id'] = new sfWidgetFormInputHidden();
      $schema['to_id'] = new sfWidgetFormInputHidden();
      $schema['is_public'] = new sfWidgetFormInputHidden();
      $schema['is_unread'] = new sfWidgetFormInputHidden();
      $this->form->setWidgetSchema($schema);
      $this->posts = new sfPropelPager('Message', sfConfig::get('app_max_status_per_page'));
      $this->posts->setCriteria($this->sfGuardUserProfile->getFriendsPostsCriteria());
      $this->posts->setPage($request->getParameter('page', 1));
      $this->posts->init();
    }
  }

  public function executeMessages(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    $this->forward404Unless($this->sfGuardUserProfile);
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $id = $this->sfGuardUserProfile->getId();
      $message = new Message();
      $message->setFromId($id);
      $message->setIsPublic(false);
      $message->setIsUnread(true);
      $this->form = new MessageForm($message);
      $schema = $this->form->getWidgetSchema();
      $validator = $this->form->getValidatorSchema();
      $schema['from_id'] = new sfWidgetFormInputHidden();
      $schema['to_id'] = new sfWidgetFormChoice(array(
        'choices' => $this->getUser()->getProfile()->getFriendsIdName()
      ));
      $validator['to_id'] = new sfValidatorChoice(array(
        'choices' => $this->getUser()->getProfile()->getFriendsIdName()
      ));
      $this->to = $schema['to_id'];
      $schema['is_public'] = new sfWidgetFormInputHidden();
      $schema['is_unread'] = new sfWidgetFormInputHidden();
      $this->form->setWidgetSchema($schema);
      $this->form->setValidatorSchema($validator);
      $critin = new Criteria();
      $critout = new Criteria();
      $critin->add(MessagePeer::IS_PUBLIC, false);
      $critout->add(MessagePeer::IS_PUBLIC, false);
      $critin->add(MessagePeer::TO_ID, $id);
      $critout->add(MessagePeer::FROM_ID, $id);
      $critin->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
      $critout->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
      $this->inbox = new sfPropelPager('Message', sfConfig::get('app_max_messages_per_page'));
      $this->inbox->setCriteria($critin);
      $this->inbox->setPage($request->getParameter('pagein', 1));
      $this->inbox->init();
      $this->outbox = new sfPropelPager('Message', sfConfig::get('app_max_messages_per_page'));
      $this->outbox->setCriteria($critout);
      $this->outbox->setPage($request->getParameter('pageout', 1));
      $this->outbox->init();
    }
  }

  public function executeBlock(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    $friend = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($friend);
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $id = $this->sfGuardUserProfile->getId();
      $criteria = new Criteria();
      $crit1 = $criteria->getNewCriterion(FriendshipPeer::USER1_ID, $id);
      $crit2 = $criteria->getNewCriterion(FriendshipPeer::USER2_ID, $request->getParameter('id'));
      $crit1->addAnd($crit2);
      $crit3 = $criteria->getNewCriterion(FriendshipPeer::USER1_ID, $request->getParameter('id'));
      $crit4 = $criteria->getNewCriterion(FriendshipPeer::USER2_ID, $id);
      $crit3->addAnd($crit4);
      $crit1->addOr($crit3);
      $criteria->add($crit1);
      $criteria->setLimit(1);  
      $friendships = FriendshipPeer::doSelect($criteria);
      if (!empty($friendships)) {
        $friendship = $friendships[0];
        $friendship->delete();
      }
      $this->redirect('profile/friends');
    }
  }

  public function executeRequest(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $this->profile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
      $this->forward404Unless($this->sfGuardUserProfile);
      $this->forward404Unless($this->profile);
      $id = $this->sfGuardUserProfile->getId();
      $criteria = new Criteria();
      $criteria->add(RequestPeer::FROM_ID, $id);
      $criteria->add(RequestPeer::TO_ID, $request->getParameter('id'));
      $criteria->setLimit(1);  
      $reqs = RequestPeer::doSelect($criteria);
      if (empty($reqs)) {
        $req = new Request();
        $req->setFromId($id);
        $req->setToId($request->getParameter('id'));
      } else {
        $req = $reqs[0];
        $req->setText('');
      }
      $req->setStatus(sfConfig::get('app_status_pending'));
      $this->form = new RequestForm($req);
      $schema = $this->form->getWidgetSchema();
      $schema['from_id'] = new sfWidgetFormInputHidden();
      $schema['to_id'] = new sfWidgetFormInputHidden();
      $schema['status'] = new sfWidgetFormInputHidden();
      $this->form->setWidgetSchema($schema);
    }
  }

  public function executeRequests(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $this->forward404Unless($this->sfGuardUserProfile);
      $id = $this->sfGuardUserProfile->getId();
      $critin = new Criteria();
      $critout = new Criteria();
      $critin->add(RequestPeer::TO_ID, $id);
      $critout->add(RequestPeer::FROM_ID, $id);
      $critin->addDescendingOrderByColumn(RequestPeer::UPDATED_AT);
      $critout->addDescendingOrderByColumn(RequestPeer::UPDATED_AT);
      $this->inbox = new sfPropelPager('Request', sfConfig::get('app_max_requests_per_page'));
      $this->inbox->setCriteria($critin);
      $this->inbox->setPage($request->getParameter('pagein', 1));
      $this->inbox->init();
      $this->outbox = new sfPropelPager('Request', sfConfig::get('app_max_requests_per_page'));
      $this->outbox->setCriteria($critout);
      $this->outbox->setPage($request->getParameter('pageout', 1));
      $this->outbox->init();
    }
  }

  public function executePics(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $this->forward404Unless($this->sfGuardUserProfile);
      $id = $this->sfGuardUserProfile->getId();
      $criteria1 = new Criteria();
      $criteria1->add(PicturePeer::OWNER_ID, $id);
      $this->pics = new sfPropelPager('Picture', sfConfig::get('app_max_pics_per_page'));
      $this->pics->setCriteria($criteria1);
      $this->pics->setPage($request->getParameter('page', 1));
      $this->pics->init();
      $criteria2 = new Criteria();
      $criteria2->add(TagPeer::USER_ID, $id);
      $this->tags = new sfPropelPager('Tag', sfConfig::get('app_max_pics_per_page'));
      $this->tags->setCriteria($criteria2);
      $this->tags->setPage($request->getParameter('pagetag', 1));
      $this->tags->init();
    }
  }

  public function executePages(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $this->forward404Unless($this->sfGuardUserProfile);
      $id = $this->sfGuardUserProfile->getId();
      $criteria1 = new Criteria();
      $criteria1->add(PagePeer::OWNER_ID, $id);
      $this->pages = new sfPropelPager('Page', sfConfig::get('app_max_pages_per_page'));
      $this->pages->setCriteria($criteria1);
      $this->pages->setPage($request->getParameter('page', 1));
      $this->pages->init();
      $criteria2 = new Criteria();
      $criteria2->add(FanPeer::USER_ID, $id);
      $this->fans = new sfPropelPager('Fan', sfConfig::get('app_max_pages_per_page'));
      $this->fans->setCriteria($criteria2);
      $this->fans->setPage($request->getParameter('pagefan', 1));
      $this->fans->init();
    }
  }

  public function executeSearchpages(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $criteria = new Criteria();
      $this->pages = new sfPropelPager('Page', sfConfig::get('app_max_pages_per_page'));
      $this->pages->setCriteria($criteria);
      $this->pages->setPage($request->getParameter('page', 1));
      $this->pages->init();
    }
  }

  public function executeView(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = $this->getUser()->getProfile();
    if ($this->sfGuardUserProfile->getFirstName() === '' || $this->sfGuardUserProfile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->sfGuardUserProfile->getId());
    } else {
      $criteria = new Criteria();
      $criteria->add(MessagePeer::IS_PUBLIC, true);
      $criteria->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
      $criteria->setLimit(sfConfig::get('app_max_status_per_profile'));
      $this->posts = $this->sfGuardUserProfile->getMessagesRelatedByFromId($criteria);
    }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->sfGuardUserProfile);
    $this->profile = $this->getUser()->getProfile();
    if ($this->profile->getFirstName() === '' || $this->profile->getLastName() === '') {
      $this->redirect('profile/edit?id='.$this->profile->getId());
    } else {
      $this->isFriend = $this->sfGuardUserProfile->isFriend($this->getUser()->getProfile());
      $message = new Message();
      $message->setFromId($this->getUser()->getProfile()->getId());
      $message->setToId($this->sfGuardUserProfile->getId());
      $message->setIsPublic(true);
      $message->setIsUnread(false);
      $this->form = new MessageForm($message);
      $schema = $this->form->getWidgetSchema();
      $schema['from_id'] = new sfWidgetFormInputHidden();
      $schema['to_id'] = new sfWidgetFormInputHidden();
      $schema['is_public'] = new sfWidgetFormInputHidden();
      $schema['is_unread'] = new sfWidgetFormInputHidden();
      $this->form->setWidgetSchema($schema);
      $this->posts = new sfPropelPager('Message', sfConfig::get('app_max_status_per_page'));
      $this->posts->setCriteria($this->sfGuardUserProfile->getFriendsPostsCriteria());
      $this->posts->setPage($request->getParameter('page', 1));
      $this->posts->init();
    }
  }

  public function executeShowprofile(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->sfGuardUserProfile);
    $criteria = new Criteria();
    $criteria->add(MessagePeer::IS_PUBLIC, true);
    $criteria->setLimit(sfConfig::get('app_max_status_per_profile'));
    $criteria->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
    $this->posts = $this->sfGuardUserProfile->getMessagesRelatedByFromId($criteria);
    $this->isFriend = $this->sfGuardUserProfile->isFriend($this->getUser()->getProfile());
    $this->isFriendOfFriends = $this->isFriend || $this->sfGuardUserProfile->isFriendOfFriends($this->getUser()->getProfile());
    $this->personalInfo = ($this->sfGuardUserProfile->getPersonalInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->sfGuardUserProfile->getPersonalInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->isFriendOfFriends) || ($this->sfGuardUserProfile->getPersonalInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->isFriend);
    $this->locationInfo = ($this->sfGuardUserProfile->getLocationInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->sfGuardUserProfile->getLocationInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->isFriendOfFriends) || ($this->sfGuardUserProfile->getLocationInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->isFriend);
    $this->academicInfo = ($this->sfGuardUserProfile->getAcademicInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->sfGuardUserProfile->getAcademicInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->isFriendOfFriends) || ($this->sfGuardUserProfile->getAcademicInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->isFriend);
    $this->profile = $this->getUser()->getProfile();
  }

  public function executeShowfriends(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getProfile();
    $this->sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
    $this->sfGuardUserProfiles = new sfPropelPager('sfGuardUserProfile', sfConfig::get('app_max_friends_per_page'));
    $this->sfGuardUserProfiles->setCriteria($this->sfGuardUserProfile->getFriendsProfilesCriteria());
    $this->sfGuardUserProfiles->setPage($request->getParameter('page', 1));
    $this->sfGuardUserProfiles->init();
    $this->isFriend = $this->sfGuardUserProfile->isFriend($this->getUser()->getProfile());
    $this->isFriendOfFriends = $this->isFriend || $this->sfGuardUserProfile->isFriendOfFriends($this->getUser()->getProfile());
    $this->friendsInfo = ($this->sfGuardUserProfile->getFriendsInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->sfGuardUserProfile->getFriendsInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->isFriendOfFriends) || ($this->sfGuardUserProfile->getFriendsInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->isFriend);
  }

  public function executeShowpics(sfWebRequest $request)
  {
    $this->sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
    $criteria1 = new Criteria();
    $criteria1->add(PicturePeer::OWNER_ID, $this->sfGuardUserProfile->getId());
    $this->pics = new sfPropelPager('Picture', sfConfig::get('app_max_pics_per_page'));
    $this->pics->setCriteria($criteria1);
    $this->pics->setPage($request->getParameter('page', 1));
    $this->pics->init();
    $criteria2 = new Criteria();
    $criteria2->add(TagPeer::USER_ID, $this->sfGuardUserProfile->getId());
    $this->tags = new sfPropelPager('Tag', sfConfig::get('app_max_pics_per_page'));
    $this->tags->setCriteria($criteria2);
    $this->tags->setPage($request->getParameter('pagetag', 1));
    $this->tags->init();
    $this->isFriend = $this->sfGuardUserProfile->isFriend($this->getUser()->getProfile());
    $this->isFriendOfFriends = $this->isFriend || $this->sfGuardUserProfile->isFriendOfFriends($this->getUser()->getProfile());
    $this->picturesInfo = ($this->sfGuardUserProfile->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->sfGuardUserProfile->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->isFriendOfFriends) || ($this->sfGuardUserProfile->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->isFriend);
  }

  public function executeShowpages(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getProfile();
    $this->sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id'));
    $criteria = new Criteria();
    $criteria->add(FanPeer::USER_ID, $this->sfGuardUserProfile->getId());
    $this->fans = new sfPropelPager('Fan', sfConfig::get('app_max_pages_per_page'));
    $this->fans->setCriteria($criteria);
    $this->fans->setPage($request->getParameter('page', 1));
    $this->fans->init();
    $this->isFriend = $this->sfGuardUserProfile->isFriend($this->getUser()->getProfile());
    $this->isFriendOfFriends = $this->isFriend || $this->sfGuardUserProfile->isFriendOfFriends($this->getUser()->getProfile());
    $this->pagesInfo = ($this->sfGuardUserProfile->getPagesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->sfGuardUserProfile->getPagesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->isFriendOfFriends) || ($this->sfGuardUserProfile->getPagesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->isFriend);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new sfGuardUserProfileForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $id = $this->getUser()->getProfile()->getId();
    $this->forward404Unless($sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($id), sprintf('Object sfGuardUserProfile does not exist (%s).', $id));
    $this->form = new sfGuardUserProfileForm($sfGuardUserProfile);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $id = $this->getUser()->getProfile()->getId();
    $this->forward404Unless($sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($id), sprintf('Object sfGuardUserProfile does not exist (%s).', $id));
    $this->form = new sfGuardUserProfileForm($sfGuardUserProfile);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $id = $this->getUser()->getProfile()->getId();
    $this->forward404Unless($sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByPk($id), sprintf('Object sfGuardUserProfile does not exist (%s).', $id));
    $sfGuardUserProfile->delete();

    $this->redirect('@homepage');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter($form->getName());
    $isOwner = ($params['id'] == $this->getUser()->getProfile()->getId());
    if ($isOwner)
    {
      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      if ($form->isValid())
      {
        $sfGuardUserProfile = $form->save();    
      }
    }
    //$this->redirect('profile/edit');
  }
}
