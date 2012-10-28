<?php

/**
 * Request filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseRequestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'from_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'to_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'text'       => new sfWidgetFormFilterInput(),
      'status'     => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'from_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'to_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'text'       => new sfValidatorPass(array('required' => false)),
      'status'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('request_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Request';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'from_id'    => 'ForeignKey',
      'to_id'      => 'ForeignKey',
      'text'       => 'Text',
      'status'     => 'ForeignKey',
      'updated_at' => 'Date',
    );
  }
}
