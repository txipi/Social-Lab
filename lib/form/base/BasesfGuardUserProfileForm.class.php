<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'first_name'              => new sfWidgetFormInputText(),
      'last_name'               => new sfWidgetFormInputText(),
      'email'                   => new sfWidgetFormInputText(),
      'gender'                  => new sfWidgetFormPropelChoice(array('model' => 'Gender', 'add_empty' => true)),
      'birthday'                => new sfWidgetFormDate(),
      'photo'                   => new sfWidgetFormInputText(),
      'location_town'           => new sfWidgetFormInputText(),
      'location_country'        => new sfWidgetFormInputText(),
      'academic_title'          => new sfWidgetFormInputText(),
      'academic_center'         => new sfWidgetFormInputText(),
      'academic_promotion'      => new sfWidgetFormInputText(),
      'personal_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'location_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'academic_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'pictures_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'pages_info_is_public'    => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'friends_info_is_public'  => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'                 => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'first_name'              => new sfValidatorString(array('max_length' => 50)),
      'last_name'               => new sfValidatorString(array('max_length' => 50)),
      'email'                   => new sfValidatorString(array('max_length' => 255)),
      'gender'                  => new sfValidatorPropelChoice(array('model' => 'Gender', 'column' => 'id', 'required' => false)),
      'birthday'                => new sfValidatorDate(array('required' => false)),
      'photo'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'location_town'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'location_country'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'academic_title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'academic_center'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'academic_promotion'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'personal_info_is_public' => new sfValidatorPropelChoice(array('model' => 'Privacy', 'column' => 'id', 'required' => false)),
      'location_info_is_public' => new sfValidatorPropelChoice(array('model' => 'Privacy', 'column' => 'id', 'required' => false)),
      'academic_info_is_public' => new sfValidatorPropelChoice(array('model' => 'Privacy', 'column' => 'id', 'required' => false)),
      'pictures_info_is_public' => new sfValidatorPropelChoice(array('model' => 'Privacy', 'column' => 'id', 'required' => false)),
      'pages_info_is_public'    => new sfValidatorPropelChoice(array('model' => 'Privacy', 'column' => 'id', 'required' => false)),
      'friends_info_is_public'  => new sfValidatorPropelChoice(array('model' => 'Privacy', 'column' => 'id', 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }


}
