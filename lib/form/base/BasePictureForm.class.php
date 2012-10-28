<?php

/**
 * Picture form base class.
 *
 * @method Picture getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BasePictureForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'owner_id'   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'title'      => new sfWidgetFormInputText(),
      'photo'      => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'owner_id'   => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id')),
      'title'      => new sfValidatorString(array('max_length' => 255)),
      'photo'      => new sfValidatorString(array('max_length' => 255)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('picture[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Picture';
  }


}
