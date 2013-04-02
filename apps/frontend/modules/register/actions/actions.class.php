<?php

/**
 * register actions.
 *
 * @package    social
 * @subpackage register
 * @author     Pablo Garaizar <garaizar@deusto.es>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if(!sfConfig::get('app_signup_enabled') || $this->getUser()->isAuthenticated())
    {
      $this->redirect('profile/wall');
    } 
    else
    {
      $this->form = new RegisterForm();
      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('sf_guard_user'));
        if ($this->form->isValid())
        {
          $this->form->save();
          $this->getUser()->signIn($this->form->getObject());
          //Send a welcome automsg from admin
          $automsg = AutomsgPeer::retrieveByPK(sfConfig::get('app_welcome_automsg'));
          $text = $automsg->getText();
          $profile = $automsg->getsfGuardUserProfile();
          $link = '<a href="/profile/show/?id='.$profile->getId().'">'.$profile.'</a>';
          $text = sprintf($text, $link);
          Social::sendMessage(sfConfig::get('app_system_id'), $this->getUser()->getProfile()->getId(), $text, false);
          //Edit profile
          $this->redirect('profile/edit');
        }
      }
    }
  }
}
