<?php

/**
 * Bot filter form base class.
 *
 * @package    social
 * @subpackage filter
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
abstract class BaseBotFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'description' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'id')),
      'description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bot_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Bot';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'user_id'     => 'ForeignKey',
      'description' => 'Text',
    );
  }
}
