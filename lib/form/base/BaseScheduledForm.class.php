<?php

/**
 * Scheduled form base class.
 *
 * @method Scheduled getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseScheduledForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'from_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'to_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'step'       => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'from_id'    => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id')),
      'to_id'      => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id')),
      'step'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'status'     => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('scheduled[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Scheduled';
  }


}
