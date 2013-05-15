<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.table');
/**
 * Cast Table class
 */
class ListingTableTransaction extends JTable
{

	function __construct(&$db) 
	{
		parent::__construct('#__barter_users_transfer_history', 'id', $db);
	}
	
	
	
}
