<?php

/**
 * sfGuardUserProfile filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BasesfGuardUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'first_name'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gender'                  => new sfWidgetFormPropelChoice(array('model' => 'Gender', 'add_empty' => true)),
      'birthday'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'photo'                   => new sfWidgetFormFilterInput(),
      'location_town'           => new sfWidgetFormFilterInput(),
      'location_country'        => new sfWidgetFormFilterInput(),
      'academic_title'          => new sfWidgetFormFilterInput(),
      'academic_center'         => new sfWidgetFormFilterInput(),
      'academic_promotion'      => new sfWidgetFormFilterInput(),
      'personal_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'location_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'academic_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'pictures_info_is_public' => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'pages_info_is_public'    => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'friends_info_is_public'  => new sfWidgetFormPropelChoice(array('model' => 'Privacy', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'first_name'              => new sfValidatorPass(array('required' => false)),
      'last_name'               => new sfValidatorPass(array('required' => false)),
      'email'                   => new sfValidatorPass(array('required' => false)),
      'gender'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Gender', 'column' => 'id')),
      'birthday'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'photo'                   => new sfValidatorPass(array('required' => false)),
      'location_town'           => new sfValidatorPass(array('required' => false)),
      'location_country'        => new sfValidatorPass(array('required' => false)),
      'academic_title'          => new sfValidatorPass(array('required' => false)),
      'academic_center'         => new sfValidatorPass(array('required' => false)),
      'academic_promotion'      => new sfValidatorPass(array('required' => false)),
      'personal_info_is_public' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Privacy', 'column' => 'id')),
      'location_info_is_public' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Privacy', 'column' => 'id')),
      'academic_info_is_public' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Privacy', 'column' => 'id')),
      'pictures_info_is_public' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Privacy', 'column' => 'id')),
      'pages_info_is_public'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Privacy', 'column' => 'id')),
      'friends_info_is_public'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Privacy', 'column' => 'id')),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'user_id'                 => 'ForeignKey',
      'first_name'              => 'Text',
      'last_name'               => 'Text',
      'email'                   => 'Text',
      'gender'                  => 'ForeignKey',
      'birthday'                => 'Date',
      'photo'                   => 'Text',
      'location_town'           => 'Text',
      'location_country'        => 'Text',
      'academic_title'          => 'Text',
      'academic_center'         => 'Text',
      'academic_promotion'      => 'Text',
      'personal_info_is_public' => 'ForeignKey',
      'location_info_is_public' => 'ForeignKey',
      'academic_info_is_public' => 'ForeignKey',
      'pictures_info_is_public' => 'ForeignKey',
      'pages_info_is_public'    => 'ForeignKey',
      'friends_info_is_public'  => 'ForeignKey',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
    );
  }
}
