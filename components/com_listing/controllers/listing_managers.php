<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controlleradmin');
 
/**
 * HelloWorlds Controller
 */

class ListingControllerListing_Managers extends JControllerAdmin
{
       
	  	public function getModel($name = 'listing_manager', $prefix = 'ListingModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
         
      
}


