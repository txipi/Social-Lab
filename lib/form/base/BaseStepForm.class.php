<?php

/**
 * Step form base class.
 *
 * @method Step getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseStepForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'bot_id'     => new sfWidgetFormPropelChoice(array('model' => 'Bot', 'add_empty' => false)),
      'command_id' => new sfWidgetFormPropelChoice(array('model' => 'Command', 'add_empty' => false)),
      'step_order' => new sfWidgetFormInputText(),
      'automsg_id' => new sfWidgetFormPropelChoice(array('model' => 'Automsg', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'bot_id'     => new sfValidatorPropelChoice(array('model' => 'Bot', 'column' => 'id')),
      'command_id' => new sfValidatorPropelChoice(array('model' => 'Command', 'column' => 'id')),
      'step_order' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'automsg_id' => new sfValidatorPropelChoice(array('model' => 'Automsg', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('step[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Step';
  }


}
