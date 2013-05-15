<?php 
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */

class ListingModelUsers extends JModelList
{
	
       protected function getListQuery()
	{
		       
			    //echo 'IN USERS';
			
                // Create a new query object.         
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
               /* $query->select('u.id as user_id,
                                    u.name as full_name,
									u.email as email,
                                    uh.total_balance as total_balance,
									uh.line_of_credit as line_of_credit,
                                    uh.total_reviews as total_reviews,uh.broker_id as broker_id');
				//print_r($query);
                $query->from('#__users u LEFT JOIN #__barter_users_history uh ON uh.user_id = u.id');
				//print_r($t);die;*/
				
				
				$query ="select a.*,a.broker_id,b.email,b.name,b.username,b.block from #__barter_users_history  as a, #__users as b where a.user_id=b.id";
                return $query;
				
				
        }
}
