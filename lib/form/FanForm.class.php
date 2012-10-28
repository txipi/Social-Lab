<?php

/**
 * Fan form.
 *
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es>
 */
class FanForm extends BaseFanForm
{
  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );
  }
}
