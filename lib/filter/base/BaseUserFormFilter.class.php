<?php

/**
 * User filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'surname'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gender'             => new sfWidgetFormPropelChoice(array('model' => 'Gender', 'add_empty' => true)),
      'birthday'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'photo'              => new sfWidgetFormFilterInput(),
      'location_town'      => new sfWidgetFormFilterInput(),
      'location_country'   => new sfWidgetFormFilterInput(),
      'academic_title'     => new sfWidgetFormFilterInput(),
      'academic_center'    => new sfWidgetFormFilterInput(),
      'academic_promotion' => new sfWidgetFormFilterInput(),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'surname'            => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'gender'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Gender', 'column' => 'id')),
      'birthday'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'photo'              => new sfValidatorPass(array('required' => false)),
      'location_town'      => new sfValidatorPass(array('required' => false)),
      'location_country'   => new sfValidatorPass(array('required' => false)),
      'academic_title'     => new sfValidatorPass(array('required' => false)),
      'academic_center'    => new sfValidatorPass(array('required' => false)),
      'academic_promotion' => new sfValidatorPass(array('required' => false)),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'surname'            => 'Text',
      'email'              => 'Text',
      'gender'             => 'ForeignKey',
      'birthday'           => 'Date',
      'photo'              => 'Text',
      'location_town'      => 'Text',
      'location_country'   => 'Text',
      'academic_title'     => 'Text',
      'academic_center'    => 'Text',
      'academic_promotion' => 'Text',
      'updated_at'         => 'Date',
    );
  }
}
