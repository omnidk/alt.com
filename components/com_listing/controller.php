<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');

require_once('libraries/joomla/database/table/user.php');
 
/**
 * General Controller of HelloWorld component
 */
class ListingController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	  function display($cachable = false) 
	{
		
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'listing'));
       
		// call parent behavior
		parent::display($cachable);
		MenuHelper::addSubmenu('messages');
	}
}
