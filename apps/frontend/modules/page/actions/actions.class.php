<?php

/**
 * page actions.
 *
 * @package    social
 * @subpackage page
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class pageActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getProfile();
    $this->Page = PagePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Page);
    $this->isOwner = ($this->Page->getOwnerId() == $this->user->getId());
    $criteria = new Criteria();
    $criteria->add(FanPeer::PAGE_ID, $request->getParameter('id'));
    $this->fans = new sfPropelPager('Fan', sfConfig::get('app_max_pages_per_page'));
    $this->fans->setCriteria($criteria);
    $this->fans->setPage($request->getParameter('page', 1));
    $this->fans->init();
    $this->isFan = ($this->getUser()->getProfile()->countFans($criteria) > 0);
  }

  public function executeFan(sfWebRequest $request)
  {
    $this->Page = PagePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Page);
    $fan = new Fan();
    $fan->setPageId($this->Page->getId());
    $fan->setUserId($this->getUser()->getProfile()->getId());
    $fan->save();
    $this->redirect('profile/pages');
  }

  public function executeUnfan(sfWebRequest $request)
  {
    $this->Page = PagePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Page);
    $criteria = new Criteria();
    $criteria->add(FanPeer::PAGE_ID, $request->getParameter('id'));
    $criteria->setLimit(1);
    $fans = $this->getUser()->getProfile()->getFans($criteria);
    if (!empty($fans))
    {
      $fan = $fans[0];
      $fan->delete();
    }
    $this->redirect('profile/pages');
  }

  public function executeNew(sfWebRequest $request)
  {
    $page = new Page();
    $page->setOwnerId($this->getUser()->getProfile()->getId());
    $this->form = new PageForm($page);
    $schema = $this->form->getWidgetSchema();
    $schema['owner_id'] = new sfWidgetFormInputHidden();
    $this->form->setWidgetSchema($schema);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PageForm();

    $this->processForm($request, $this->form);
    $schema = $this->form->getWidgetSchema();
    $schema['owner_id'] = new sfWidgetFormInputHidden();
    $this->form->setWidgetSchema($schema);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Page = PagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Page does not exist (%s).', $request->getParameter('id')));
    $this->isOwner = ($Page->getOwnerId() == $this->getUser()->getProfile()->getId());
    $this->forward404Unless($this->isOwner);   
    $this->form = new PageForm($Page);
    $schema = $this->form->getWidgetSchema();
    $schema['owner_id'] = new sfWidgetFormInputHidden();
    $this->form->setWidgetSchema($schema);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Page = PagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Page does not exist (%s).', $request->getParameter('id')));
    $this->isOwner = ($Page->getOwnerId() == $this->getUser()->getProfile()->getId());
    $this->forward404Unless($this->isOwner);   
    $this->form = new PageForm($Page);

    $this->processForm($request, $this->form);

    $this->redirect('profile/pages');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Page = PagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Page does not exist (%s).', $request->getParameter('id')));
    $Page->delete();

    $this->redirect('profile/pages');
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
        $Page = $form->save();
      }
    }
    $this->redirect('profile/pages');
  }
}
