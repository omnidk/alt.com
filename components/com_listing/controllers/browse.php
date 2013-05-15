<?php 
//No direct access
defined('_JEXEC') or die('Restricted Access');

//import joomla control library
jimport('joomla.application.component.controller');
require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');

class ListingControllerBrowse extends JController
{
	function display($tpl=null)

		{
		  JRequest::setVar( 'view', 'browse' );
		  parent::display();

		}
		
		function browseshow()
		{
				JRequest::setVar( 'view', 'browse' );
				JRequest::setVar( 'layout','browseshow' );
		
				  parent::display();
		}
		function browseshows()
		{
		
				JRequest::setVar( 'view', 'browse' );
				JRequest::setVar( 'layout','browseshows' );
		
				  parent::display();
		}
		
}

