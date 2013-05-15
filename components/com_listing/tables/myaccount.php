<?php
class TableMyaccount extends JTable
{

	
	var $id = null;
	
	

	 function TableMyaccount(& $db)

	 { 

	 	parent::__construct('#__barter_user_messages', 'id', $db);

	 }


	

}
