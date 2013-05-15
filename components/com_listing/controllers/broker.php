<?php  defined('_JEXEC') or die('Restrict Access'); 
jimport('joomla.application.component.controller');
//require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.COMPONENT.DS.'tables'.DS.'broker.php');

class ListingControllerBroker extends JController
{
	function __construct()

	   {
		  parent::__construct();
	   }

	function display($tpl=null)

		{

		  JRequest::setVar( 'view', 'broker' );
		  parent::display();

		}
	function save() 
	  {  
				
			$model = $this->getModel('broker');
											
			if($model->store($_POST))
			{
			
				$msg = JText::_('broker Setting Was Successfully Set');
			
			}
			else
			{
			
				$msg = JText::_('Error In broker Setting');
			
			}
			
			$link = 'index.php?option=com_listing&view=broker';
			
			$this->setRedirect($link, $msg);		

	  }
}