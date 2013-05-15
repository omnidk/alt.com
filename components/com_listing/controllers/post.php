<?php 
//No direct access
defined('_JEXEC') or die('Restricted Access');

//import joomla control library
jimport('joomla.application.component.controller');
require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'post.php');
//require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."tables". DS ."listing_manager.php");

class ListingControllerPost extends JController
{
	
	function save() 
	  {  
				
			$model = $this->getModel('post');
			//print_r($_POST);die;						
			if($model->store($_POST))
			{
			
				$msg = JText::_('Listing Creation Successful');
			
			}
			else
			{
			
				$msg = JText::_('Sorry, error#3');
			
			}
			
			//$link = 'index.php?option=com_listing&view=post';
			//$p_id = JRequest::getVar('id');
			$db = & JFactory::getDBO();
			$userdetails = "select id from #__barter_listing order by id desc limit 0,1";
			$db->setQuery($userdetails);
			$user_detail = $db->loadAssoc(); 
			$p_id = $user_detail['id'];
			$link = 'index.php?option=com_listing&view=mylistings';
			$this->setRedirect($link, $msg);		

	  }
}