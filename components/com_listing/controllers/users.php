<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controlleradmin');
 
/**
 * users Controller
 */

class ListingControllerUsers extends JControllerAdmin
{
	public function getModel($name = 'user', $prefix = 'ListingModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
         
      
}


