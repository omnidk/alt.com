<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.table');

 
 
 
class ListingTableListing_Manager extends JTable
{

	function __construct(&$db) 
	{
		parent::__construct('#__barter_listing', 'id', $db);
	}
	
	
	
}
