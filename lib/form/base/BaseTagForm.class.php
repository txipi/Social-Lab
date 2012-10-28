<?php

/**
 * Tag form base class.
 *
 * @method Tag getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseTagForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'picture_id' => new sfWidgetFormPropelChoice(array('model' => 'Picture', 'add_empty' => false)),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'picture_id' => new sfValidatorPropelChoice(array('model' => 'Picture', 'column' => 'id')),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id')),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tag';
  }


}
