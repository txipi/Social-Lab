<?php

/**
 * request actions.
 *
 * @package    social
 * @subpackage request
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class requestActions extends sfActions
{
  public function executeAccept(sfWebRequest $request)
  {
    $this->forward404Unless($Request = RequestPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));

    if ($Request->getToId() == $this->getUser()->getProfile()->getId())
    {
      $Friendship = new Friendship();
      $Friendship->setUser1Id($Request->getFromId());
      $Friendship->setUser2Id($this->getUser()->getProfile()->getId());
      $Friendship->save();
      $Request->setStatus(sfConfig::get('app_status_accepted'));
      $Request->save();
    }

    $this->redirect('profile/requests');
  }

  public function executeReject(sfWebRequest $request)
  {
    $this->forward404Unless($Request = RequestPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));

    if ($Request->getToId() == $this->getUser()->getProfile()->getId())
    {
      $Request->setStatus(sfConfig::get('app_status_rejected'));
      $Request->save();
    }

    $this->redirect('profile/requests');
  }

  public function executeMessage(sfWebRequest $request)
  {
    $this->forward404Unless($Request = RequestPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Message does not exist (%s).', $request->getParameter('id')));

    if ($Request->getFromId() == $this->getUser()->getProfile()->getId())
    {
      $message = new Message();
      $message->setFromId($Request->getToId());
      $message->setToId($Request->getFromId());
      $message->setIsPublic(false);
      $message->setIsUnread(true);
      $this->form = new MessageForm($message);
      $schema = $this->form->getWidgetSchema();
      $schema['from_id'] = new sfWidgetFormInputHidden();
      $schema['to_id'] = new sfWidgetFormInputHidden();
      $schema['is_public'] = new sfWidgetFormInputHidden();
      $schema['is_unread'] = new sfWidgetFormInputHidden();
      $this->form->setWidgetSchema($schema);
      $this->profile = sfGuardUserProfilePeer::retrieveByPk($Request->getFromId());
    } 
    else 
    {
      $this->redirect('profile/requests');
    }    
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new RequestForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Request = RequestPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Request does not exist (%s).', $request->getParameter('id')));
    if ($Request->getFromId() == $this->getUser()->getProfile()->getId())
    {
      $this->form = new RequestForm($Request);
      $this->processForm($request, $this->form);
      $this->setTemplate('edit');
    }
    else
    {
      $this->redirect('profile/requests');
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Request = RequestPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Request does not exist (%s).', $request->getParameter('id')));
    $Request->delete();

    $this->redirect('profile/requests');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $params = $request->getParameter($form->getName());
      if ($params['from_id'] !=  $params['to_id'] && $params['from_id'] == $this->getUser()->getProfile()->getId())
      {
        $criteria = new Criteria();
        $criteria->add(RequestPeer::FROM_ID, $params['from_id']);
        $criteria->add(RequestPeer::TO_ID, $params['to_id']);
        $requests = RequestPeer::doSelect($criteria);
        if (empty($requests) || $requests[0]->getStatus() !== sfConfig::get('app_status_pending'))
        {
          $criteria = new Criteria();
          $criteria->add(BotPeer::USER_ID, $params['to_id']);
          $isBot = (BotPeer::doCount($criteria) > 0);
          if ($isBot)
          {
            //It is a bot, schedule an automatic task
            $scheduled = new Scheduled();
            $scheduled->setFromId($params['to_id']);
            $scheduled->setToId($params['from_id']);
            $scheduled->setStep(0);
            $scheduled->setStatus(sfConfig::get('app_status_pending'));
            $scheduled->save();
          }
        } 
        $Request = $form->save();
      }
      $this->redirect('profile/requests');
    }
  }
}
