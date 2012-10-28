<?php

/**
 * Page form.
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class PageForm extends BasePageForm
{
  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );
    $this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
      'label' => 'Photo',
      'file_src'  => '/uploads/pages/'.$this->getObject()->getPhoto(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div class="float_l">%file%</div><div class="cleaner"></div><br /><div class="float_r">%input%</div><div class="float_l">%delete% %delete_label%</div>'
    ));
    $this->validatorSchema['photo'] = new sfValidatorFile(array(
      'required' => true,
      'path' => sfConfig::get('sf_upload_dir').'/pages',
      'mime_types' => 'web_images',
    ));
    $this->widgetSchema->setLabels(array(
      'photo' => 'Picture',
    ));
  }
}
