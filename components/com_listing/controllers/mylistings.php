<?php 
//No direct access
defined('_JEXEC') or die('Restricted Access');

//import joomla control library
jimport('joomla.application.component.controller');
require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');

class ListingControllerMyListings extends JController
{
	function display($tpl=null)

		{

		  JRequest::setVar( 'view', 'mylistings' );
		  parent::display();

		}
		
		function edit()
		{
				JRequest::setVar( 'view', 'mylistings' );
				JRequest::setVar( 'layout','edit' );
		
				  parent::display();
		}
		public function remove()
	{
		//echo "dfd";die;
		
		$model = $this->getModel('mylistings');
		
		if(!$model->delete()) {
			$msg = JText::_( 'Error Deleting Listing' );
		} else {
			$msg = JText::_( 'Listing Successfully Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_listing&view=mylistings', $msg );
	}
		
		
		function save() 
	  {  	
			$model = $this->getModel('mylistings');
			if($model->store($_POST))
			{
			    
				$msg = JText::_('Request Was Successfully edit');
			
			}
			else
			{
			
				$msg = JText::_('Error In Request Sending');
			
			}
			$p_id = JRequest::getVar('id');
			$link = 'index.php?option=com_listing&view=mylistings&layout=editpost&id='.$p_id;
			
			$this->setRedirect($link, $msg);		

	  }
}