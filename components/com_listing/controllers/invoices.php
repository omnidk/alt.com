<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controlleradmin');
 
/**
 * HelloWorlds Controller
 */

class ListingControllerInvoices extends JControllerAdmin
{
       
	  	public function getModel($name = 'invoice', $prefix = 'ListingModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	function generateInvoice()
		{
		
				JRequest::setVar( 'view', 'invoices' );
				JRequest::setVar( 'layout','generateInvoice' );
		
				  parent::display();
		}
         
      
}


