<?php

/**
 * Gender form base class.
 *
 * @method Gender getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseGenderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'name' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name' => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('gender[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gender';
  }


}
