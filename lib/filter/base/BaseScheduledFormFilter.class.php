<?php

/**
 * Scheduled filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseScheduledFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'from_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'to_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'step'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'     => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'from_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'to_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'step'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'status'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('scheduled_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Scheduled';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'from_id'    => 'ForeignKey',
      'to_id'      => 'ForeignKey',
      'step'       => 'Number',
      'status'     => 'ForeignKey',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
