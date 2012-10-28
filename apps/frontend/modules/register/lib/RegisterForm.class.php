<?php
class RegisterForm extends sfGuardUserForm
{
  public function configure()
  {
    // Remove all widgets we don't want to show
    unset(
      $this['is_active'],
      $this['is_super_admin'],
      $this['updated_at'],
      $this['groups_list'],
      $this['permissions_list'],
      $this['last_login'],
      $this['created_at'],
      $this['salt'],
      $this['sf_guard_user_group_list'],
      $this['sf_guard_user_permission_list'],
      $this['algorithm']
    );
 
    // Setup proper password validation with confirmation
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_confirmation'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_confirmation'] = clone $this->validatorSchema['password'];
 
    $this->widgetSchema->moveField('password_confirmation', 'after', 'password');
 
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array(), array('invalid' => 'The two passwords must be the same.')));
  }
}
