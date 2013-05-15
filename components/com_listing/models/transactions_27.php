<?php 
defined('_JEXEC') or die('Restricted access');
 //echo 'hiiiiiiiiii';die;
// import Joomla modelform library
 
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */

class ListingModelTransactions extends JModelList
{
	
       protected function getListQuery()
	{
		        $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('*');
				//print_r($query);
                $query->from('#__barter_users_transfer_history');
				//print_r($t);die;
				
                return $query;
			 
			 /*?> echo $credit=JRequest::getVar('credit');
			  echo $startdate=JRequest::getVar('startdate');
			 echo $enddate=JRequest::getVar('enddate');
			  
                $db = JFactory::getDBO();
				///$database->setQuery("SELECT * FROM #__barter_users_history WHERE broker_id = $broker_id");
		        //database->query();
		        //$num_rows = $database->getNumRows();
		        //$rows = $database->loadObjectList();
                
				
				/*$query="SELECT u.id as user_id,
											u.name as full_name,
											u.email as email,
											uh.total_balance as total_balance,
											uh.line_of_credit as line_of_credit,
											uh.total_reviews as total_reviews									
									 FROM #__users u 
									 LEFT JOIN #__barter_users_history uh ON uh.user_id = u.id
									 WHERE u.id = $credit
									";*/
				
				//echo $query; die;
			 /*?>$db->query();
				
				$query = $db->getQuery(true);
                // Select some fields
                $query->select('*');
				//print_r($query);
                $query->from('#__barter_users_transfer_history');
				//print_r($t);die;
				
                return $rows;<?php */
				
				
        }
}
