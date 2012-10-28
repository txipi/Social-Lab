<?php

/**
 * pic actions.
 *
 * @package    social
 * @subpackage pic
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class picActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getProfile();
    $this->Picture = PicturePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Picture);
    $this->isOwner = ($this->Picture->getOwnerId() == $this->user->getId());
    $canSee = $this->isOwner || ($this->Picture->getsfGuardUserProfile()->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($this->Picture->getsfGuardUserProfile()->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $this->Picture->getsfGuardUserProfile()->isFriendOfFriends($this->user)) || ($this->Picture->getsfGuardUserProfile()->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $this->Picture->getsfGuardUserProfile()->isFriend($this->user));
    $this->forward404Unless($canSee);
    $criteria = new Criteria();
    $criteria->add(TagPeer::PICTURE_ID, $request->getParameter('id'));
    $this->tags = new sfPropelPager('Tag', sfConfig::get('app_max_pics_per_page'));
    $this->tags->setCriteria($criteria);
    $this->tags->setPage($request->getParameter('page', 1));
    $this->tags->init();
    $tag = new Tag();
    $tag->setPictureId($request->getParameter('id'));
    $this->form = new TagForm($tag);
    $schema = $this->form->getWidgetSchema();
    $schema['picture_id'] = new sfWidgetFormInputHidden();
    $schema['user_id'] = new sfWidgetFormChoice(array(
      'choices' => $this->getUser()->getProfile()->getFriendsIdName()
    ));
    $validator['user_id'] = new sfValidatorChoice(array(
      'choices' => $this->getUser()->getProfile()->getFriendsIdName()
    ));
    $this->form->setWidgetSchema($schema);
  }

  public function executeUntag(sfWebRequest $request)
  {
    $picture = PicturePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($picture);
    $isOwner = ($picture->getOwnerId() == $this->getUser()->getProfile()->getId());
    if ($isOwner || $request->getParameter('user') == $this->getUser()->getProfile()->getId())
    {
      $criteria = new Criteria();
      $criteria->add(TagPeer::PICTURE_ID, $request->getParameter('id'));
      $criteria->add(TagPeer::USER_ID, $request->getParameter('user'));
      $tags = TagPeer::doSelect($criteria);
      foreach ($tags as $tag)
      {
        $tag->delete();
      }
    }
    $this->redirect('pic/show?id='.$picture->getId());
  }

  public function executeNew(sfWebRequest $request)
  {
    $pic = new Picture();
    $pic->setOwnerId($this->getUser()->getProfile()->getId());
    $this->form = new PictureForm($pic);
    $schema = $this->form->getWidgetSchema();
    $schema['owner_id'] = new sfWidgetFormInputHidden();
    $this->form->setWidgetSchema($schema);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PictureForm();

    $this->processForm($request, $this->form);
    $schema = $this->form->getWidgetSchema();
    $schema['owner_id'] = new sfWidgetFormInputHidden();
    $this->form->setWidgetSchema($schema);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Picture = PicturePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Picture does not exist (%s).', $request->getParameter('id')));
    $this->isOwner = ($Picture->getOwnerId() == $this->getUser()->getProfile()->getId());
    $this->forward404Unless($this->isOwner);
    $this->form = new PictureForm($Picture);
    $schema = $this->form->getWidgetSchema();
    $schema['owner_id'] = new sfWidgetFormInputHidden();
    $this->form->setWidgetSchema($schema);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Picture = PicturePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Picture does not exist (%s).', $request->getParameter('id')));
    $this->isOwner = ($Picture->getOwnerId() == $this->getUser()->getProfile()->getId());
    $this->forward404Unless($this->isOwner);
    $this->form = new PictureForm($Picture);
    $this->processForm($request, $this->form);
    $this->redirect('profile/pics');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Picture = PicturePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Picture does not exist (%s).', $request->getParameter('id')));
    $Picture->delete();

    $this->redirect('profile/pics');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter($form->getName());
    $isOwner = ($params['owner_id'] == $this->getUser()->getProfile()->getId());
    if ($isOwner)
    {
      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      if ($form->isValid())
      {
        $Picture = $form->save();
        $this->redirect('pic/show?id='.$Picture->getId());
      }
    }
    $this->redirect('profile/pics');
  }
}
