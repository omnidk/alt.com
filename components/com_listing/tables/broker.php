<?php  
class TableBroker extends JTable
{

var $id              = null;
	
	
function TableBroker(& $db)
{ 
parent::__construct('#__barter_users_transfer_history', 'id', $db);
}


	

}
