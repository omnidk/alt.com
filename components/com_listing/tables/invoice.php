<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.table');

 
 
 
class ListingTableInvoice extends JTable
{

	function __construct(&$db) 
	{
		parent::__construct('#__barter_invoices', 'id', $db);
	}
	
	
	
}
