<?php defined('_JEXEC') or die('Restricted access');
 
// import Joomla library
jimport('joomla.application.component.controller');
// echo 'hiiiii';die;
/**
 * Categories Controller
 */

class  ListingControllerAccount extends JController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
    function accountupdates()
	{  
		$database 	          = & JFactory::getDBO();
		$account_id           = $_REQUEST['account_id'];
		$comission_percent    = $_REQUEST['comission_percent'];
		$payment_title        = $_REQUEST['payment_title'];		
		$user_default       = $_REQUEST['user_default'];
		$from_email       = $_REQUEST['from_email'];
		$from_name       = $_REQUEST['from_name'];
		//
		
		$row_update=$database->setQuery("update #__barter_account set comission_percent='$comission_percent',payment_title='$payment_title', default_user = '$user_default' , from_email = '$from_email', from_name = '$from_name'  where id=$account_id");
		$database->query();
			
		header("Location: index.php?option=com_listing&view=account");
	}
	
   	
}