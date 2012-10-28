<?php

/**
 * Picture filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BasePictureFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'owner_id'   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'title'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'photo'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'owner_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'title'      => new sfValidatorPass(array('required' => false)),
      'photo'      => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('picture_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Picture';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'owner_id'   => 'ForeignKey',
      'title'      => 'Text',
      'photo'      => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
