<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport( 'joomla.application.component.model' );
/**
 * HelloWorldList Model
 */

class ListingModelAccount extends JModel
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	 
	 
	 function accountupdate()
	{ 
		$database 	          = & JFactory::getDBO();
		$account_id           = $_REQUEST['account_id'];
		$comission_percent    = $_REQUEST['comission_percent'];
		$payment_title        = $_REQUEST['payment_title'];

		$row_update=$database->setQuery("update #__barter_account set comission_percent='$comission_percent',payment_title='$payment_title' where id=$account_id");
		$database->query();
			
		header("Location: index.php?option=com_listing&view=account");
	}
	
}
