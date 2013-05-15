<?php  
class TableAccount extends JTable
{

var $id              = null;
	
	
function TableAccount(& $db)
{ 
parent::__construct('#__barter_account', 'id', $db);
}


	

}
