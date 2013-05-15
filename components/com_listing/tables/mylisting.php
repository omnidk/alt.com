<?php
class TableMylisting extends JTable
{

	
	var $id = null;
	 function TableMylisting(& $db)

	 { 

	 	parent::__construct('#__barter_listing', 'id', $db);

	 }


	

}




