<?php

/**
 * Tag filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseTagFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'picture_id' => new sfWidgetFormPropelChoice(array('model' => 'Picture', 'add_empty' => true)),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'picture_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Picture', 'column' => 'id')),
      'user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tag_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tag';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'picture_id' => 'ForeignKey',
      'user_id'    => 'ForeignKey',
      'updated_at' => 'Date',
    );
  }
}
