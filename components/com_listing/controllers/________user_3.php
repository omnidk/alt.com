<?php 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * user Controller
 */

class  ListingControllerUser extends JControllerForm
{
	 function display($tpl=null)

		{
		  JRequest::setVar( 'view', 'user' );
		  parent::display();
		}
		
		function add()
		{
		JRequest::setVar( 'view', 'user' );
		JRequest::setVar( 'layout', 'new' );
		 parent::display();
		
		}
	function save() 
	  {  
			$model = $this->getModel('broker');
			if($model->store1($_POST))
			{
			
				$msg = JText::_('');
			
			}
			else
			{
			
				$msg = JText::_('Error In broker Setting');
			
			}
			
			$link = 'index.php?option=com_listing&view=users';
			
			$this->setRedirect($link, $msg);		

	  }

}