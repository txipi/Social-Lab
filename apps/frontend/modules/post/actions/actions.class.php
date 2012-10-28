<?php

/**
 * post actions.
 *
 * @package    social
 * @subpackage post
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class postActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new MessageForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Message = MessagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));
    $this->isOwner = ($Message->getFromId() == $this->getUser()->getProfile()->getId());
    $this->forward404Unless($isOwner);
    $this->form = new MessageForm($Message);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Message = MessagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));
    $Message->delete();

    $this->redirect('profile/wall');
  }

  public function executeRead(sfWebRequest $request)
  {
    $this->forward404Unless($Message = MessagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));

    if ($Message->getToId() == $this->getUser()->getProfile()->getId())
    {
      $Message->setIsUnread(false);
      $Message->save();
    }

    $this->redirect('profile/messages');
  }

  public function executeUnread(sfWebRequest $request)
  {
    $this->forward404Unless($Message = MessagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));
    if ($Message->getToId() == $this->getUser()->getProfile()->getId())
    {
      $Message->setIsUnread(true);
      $Message->save();
    }

    $this->redirect('profile/messages');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter($form->getName());
    $isOwner = ($params['from_id'] == $this->getUser()->getProfile()->getId());
    if ($isOwner)
    {
      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      if ($form->isValid() && $form->getValue('text') !== '')
      {
        $Message = $form->save();
        if($Message->getIsPublic())
        {
          if($Message->getFromId() == $Message->getToId())
          {
            $this->redirect('profile/wall');
          }
          else
          {
            $this->redirect('profile/show?id='.$Message->getToId());
          }
        }
        else
        {
          $this->redirect('profile/messages');
        }
      }
      else
      {
        $this->redirect('profile/wall');
      }
    }
  }
}
