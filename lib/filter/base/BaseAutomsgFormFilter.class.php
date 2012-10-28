<?php

/**
 * Automsg filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseAutomsgFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'text'    => new sfWidgetFormFilterInput(),
      'user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'text'    => new sfValidatorPass(array('required' => false)),
      'user_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('automsg_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Automsg';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'text'    => 'Text',
      'user_id' => 'ForeignKey',
    );
  }
}
