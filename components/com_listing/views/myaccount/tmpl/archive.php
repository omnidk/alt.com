<?php
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
$user =& JFactory::getUser();



	$user_id=$user->get('id');

	

	$offer_id = JRequest::getInt('offer_id');



	$db	=& JFactory::getDBO();



	$db->setQuery("SELECT lo.id as id,



                          lo.listing_id as listing_id,



                          lo.offered_by as offered_by,



						  lo.offered_to as offered_to



	               FROM #__barter_listing_offer lo



				   WHERE lo.id = $offer_id");



	$rows = $db->loadAssoc();



	



	if($user_id == $rows['offered_by'])



	{



		//update is_archived_by_seller



		$db->setQuery("UPDATE #__barter_listing_offer SET is_archived_by_buyer = 1  WHERE id = $offer_id");



		$db->query();



	}



	else



	{



		//update is_archived_by_seller



		$db->setQuery("UPDATE #__barter_listing_offer SET is_archived_by_seller = 1  WHERE id = $offer_id");



		$db->query();



	}



	header("Location: index.php?option=com_listing&view=myaccount&layout=offerview&offer_id=$offer_id");

