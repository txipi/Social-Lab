<?php

/**
 * tag actions.
 *
 * @package    social
 * @subpackage tag
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class tagActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TagForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Tag = TagPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Tag does not exist (%s).', $request->getParameter('id')));
    $this->form = new TagForm($Tag);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Tag = TagPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Tag does not exist (%s).', $request->getParameter('id')));
    $Tag->delete();

    $this->redirect('pic/show?id='.$Tag->getPictureId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter($form->getName());
    $criteria1 = new Criteria();
    $criteria1->add(TagPeer::PICTURE_ID, $params['picture_id']);
    $criteria1->add(TagPeer::USER_ID, $params['user_id']);
    $tags = FanPeer::doCount($criteria1);
    if ($tags == 0) 
    {
      $criteria2 = new Criteria();
      $criteria2->add(PicturePeer::ID, $params['picture_id']);
      $criteria2->add(PicturePeer::OWNER_ID, $this->getUser()->getProfile()->getId());
      $isOwner = (PicturePeer::doCount($criteria2) > 0);
      if ($isOwner)
      {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
          $Tag = $form->save();
        }
      }
    }
    $this->redirect('pic/show?id='.$params['picture_id']);
  }
}
