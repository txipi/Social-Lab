<?php

/**
 * Message form.
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class MessageForm extends BaseMessageForm
{
  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );
  }
}
