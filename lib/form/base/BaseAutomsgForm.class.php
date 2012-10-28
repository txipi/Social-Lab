<?php

/**
 * Automsg form base class.
 *
 * @method Automsg getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseAutomsgForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'text'    => new sfWidgetFormTextarea(),
      'user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'text'    => new sfValidatorString(array('required' => false)),
      'user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('automsg[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Automsg';
  }


}
