<?php 
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */

class ListingModelInvoices extends JModelList
{
	
       protected function getListQuery()
	{
		       
			 
			   // $filter=JRequest::getVar('filter_search');
                // Create a new query object.         
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('*');
				//print_r($query);
                $query->from('#__barter_invoices ');
				//print_r($t);die;
				
                return $query;
				
				
        }
}
