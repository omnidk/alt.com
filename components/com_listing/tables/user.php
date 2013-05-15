<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.table');
class ListingTableUser extends JTable
{

	function __construct(&$db) 
	{
		parent::__construct('#__barter_users_history', 'id', $db);
	}
	
	
	
}
