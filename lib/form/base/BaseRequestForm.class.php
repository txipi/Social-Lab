<?php

/**
 * Request form base class.
 *
 * @method Request getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseRequestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'from_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'to_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'text'       => new sfWidgetFormTextarea(),
      'status'     => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'from_id'    => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id')),
      'to_id'      => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id')),
      'text'       => new sfValidatorString(array('required' => false)),
      'status'     => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Request';
  }


}
