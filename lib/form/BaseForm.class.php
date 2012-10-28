<?php

/**
 * Base project form.
 * 
 * @package    social
 * @subpackage form
 * @author     Pablo Garaizar <garaizar@deusto.es> 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
	public function debug()
	{
	  if (sfConfig::get('sf_environment') != 'dev')
	  {
	    return;
	  }
	  foreach($this->getErrorSchema()->getErrors() as $key => $error)
	  {
	    echo '<p>' . $key . ': ' . $error . '</p>';
	  }
	}
}
