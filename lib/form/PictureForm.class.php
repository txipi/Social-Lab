<?php

/**
 * Picture form.
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class PictureForm extends BasePictureForm
{
  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );
    $this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
      'label' => 'Photo',
      'file_src'  => '/uploads/pics/'.$this->getObject()->getPhoto(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div class="float_l">%file%</div><div class="float_r">%input%<br /><br />%delete% %delete_label%</div>'
    ));

    $this->validatorSchema['photo'] = new sfValidatorFile(array(
      'required' => true,
      'path' => sfConfig::get('sf_upload_dir').'/pics',
      'mime_types' => 'web_images',
    ));
    $this->widgetSchema->setLabels(array(
      'photo' => 'Picture',
    ));
  }
}
