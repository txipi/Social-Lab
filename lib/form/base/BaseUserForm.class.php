<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'surname'            => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'gender'             => new sfWidgetFormPropelChoice(array('model' => 'Gender', 'add_empty' => true)),
      'birthday'           => new sfWidgetFormDate(),
      'photo'              => new sfWidgetFormInputText(),
      'location_town'      => new sfWidgetFormInputText(),
      'location_country'   => new sfWidgetFormInputText(),
      'academic_title'     => new sfWidgetFormInputText(),
      'academic_center'    => new sfWidgetFormInputText(),
      'academic_promotion' => new sfWidgetFormInputText(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 255)),
      'surname'            => new sfValidatorString(array('max_length' => 255)),
      'email'              => new sfValidatorString(array('max_length' => 255)),
      'gender'             => new sfValidatorPropelChoice(array('model' => 'Gender', 'column' => 'id', 'required' => false)),
      'birthday'           => new sfValidatorDate(array('required' => false)),
      'photo'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'location_town'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'location_country'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'academic_title'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'academic_center'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'academic_promotion' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }


}
