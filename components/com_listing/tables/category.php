<?php 
defined('_JEXEC') or die('Redirected Accesss');
//echo 'hiiiiiiii table';die;
 jimport('joomla.database.table');


class ListingTableCategory extends JTable
{

function  __construct(& $db)
{ 
parent::__construct('#__barter_category', 'id', $db);
}

}
