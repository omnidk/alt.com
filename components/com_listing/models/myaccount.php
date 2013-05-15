<?php
//No direct Access
defined('_JEXEC') or die('Restricted Access');

//import joomla modelform library
jimport('joomla.application.component.model');
//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");

class ListingModelMyaccount extends JModel
{
	function store1(){
	$db 	  		= & JFactory::getDBO();

	$receiver_username	= JRequest::getVar('receiver_username');
	$listing_title 		= JRequest::getVar('listing_title');
	$subject			= JRequest::getVar('subject');
	$message			= JRequest::getVar('message');
	$listing_id			= JRequest::getVar('listing_id');
	$seller_id			= JRequest::getVar('seller_id');

	ListingHelper::checkLoggedInUser();
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	

	
	$userdetails = "SELECT * FROM #__users WHERE username = '".$receiver_username."' limit 0,1";
	$db->setQuery($userdetails);
	$user_detail = $db->loadAssoc(); 
	$recieverid = $user_detail['id'];

	$recieverblock = ListingHelper::detail('#__barter_users_history','','default_user','id',$receiverID ,'','loadresult');
	if($recieverblock == '1'){
		//$this->setError('Sorry! Right now '.$receiverName.' is blocked.');
		return false;
	}
	
	$sql = "";
	$sql .= "INSERT INTO #__barter_user_messages (id, sender_id, receiver_id, listing_id, subject, message, is_read, created_date, parent_id) ";
	$sql .= " VALUES ('', '$user_id', '$recieverid', '$listing_id', '$subject', '$message', '', SYSDATE(), '')";
	$db->setQuery($sql);
	$db->query();
	return true;
	//echo $sql;
	//	die('STOP');
	}
}