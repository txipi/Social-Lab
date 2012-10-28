<?php

/**
 * Friendship form.
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class FriendshipForm extends BaseFriendshipForm
{
  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );
  }
}
