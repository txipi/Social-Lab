<?php

/**
 * Step filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseStepFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'bot_id'     => new sfWidgetFormPropelChoice(array('model' => 'Bot', 'add_empty' => true)),
      'command_id' => new sfWidgetFormPropelChoice(array('model' => 'Command', 'add_empty' => true)),
      'step_order' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'automsg_id' => new sfWidgetFormPropelChoice(array('model' => 'Automsg', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'bot_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Bot', 'column' => 'id')),
      'command_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Command', 'column' => 'id')),
      'step_order' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'automsg_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Automsg', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('step_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Step';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'bot_id'     => 'ForeignKey',
      'command_id' => 'ForeignKey',
      'step_order' => 'Number',
      'automsg_id' => 'ForeignKey',
    );
  }
}
