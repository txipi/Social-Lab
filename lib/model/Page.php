<?php


/**
 * Skeleton subclass for representing a row from the 'page' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Mon Oct  8 22:53:39 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Page extends BasePage {

  public function __toString() 
  {
    return $this->getTitle();
  } 

  public function setPhoto($v)
  {
    parent::setPhoto($v);
    $filepath = sfConfig::get('sf_upload_dir').'/pages/'.$this->getPhoto();
    $smallpath = sfConfig::get('sf_upload_dir').'/pages/small-'.$this->getPhoto();
    $big = new sfThumbnail(608, 456, false, true, 75, 'sfImageMagickAdapter', array('method' => 'shave_all'));
    $big->loadFile($filepath);
    $small = new sfThumbnail(80, 60, false, true, 75, 'sfImageMagickAdapter', array('method' => 'shave_bottom'));
    $small->loadFile($filepath);
    $big->save($filepath);
    $small->save($smallpath);
  }

} // Page
