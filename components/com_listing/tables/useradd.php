<?php  
class TableUseradd extends JTable
{

var $id              = null;
	
	
function TableUseradd(& $db)
{ 
parent::__construct('#__barter_users_history', 'id', $db);
}


	

}