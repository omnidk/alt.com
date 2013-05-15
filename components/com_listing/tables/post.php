<?php
class TablePost extends JTable
{

	
	var $id = null;
	
	

	 function TablePost(& $db)

	 { 

	 	parent::__construct('#__barter_listing', 'id', $db);

	 }


	

}
