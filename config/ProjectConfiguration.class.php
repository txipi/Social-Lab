<?php

require_once dirname(dirname(__FILE__)).'/lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelPlugin');
    $this->enablePlugins('sfGuardPlugin');
    $this->enablePlugins('sfThumbnailPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
  }
}
