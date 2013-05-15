<?php 
//No direct Access
defined('_JEXEC') or die('Restricted Access');

//import joomla modelform library
jimport('joomla.application.component.model');
//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');
require_once(JPATH_COMPONENT.DS.'tables'.DS.'mylisting.php');
class ListingModelMylistings extends JModel
{	
     var $_data = null;
	 var $_total=null;
	 function __construct()
	  {
	   parent::__construct();
	  }
	  
	  function getTotal()
	 {

			if (empty($this->_total))
			{
	
				$query = $this->_buildQuery();
	
				$this->_total = $this->_getListCount($query);
	
			}

			return $this->_total;

	 } 
	 
	  function _buildQuery()
	{
		
		$user =& JFactory::getUser();
        $user_id=$user->get('id');
        $database 	= & JFactory::getDBO();
		 $database->setQuery("SELECT * FROM #__barter_listing
						");
    $database->query();
   $query = $database->loadObjectList();
   //print_r($query);die;
  return $query; 
		
	}
	  function &getData()
			{ 
					$query = $this->_buildQuery();
					
			 		$limitstart = $this->getState('limitstart');
			 
       				 $limit = $this->getState('limit');
			 
					$this->_db->setQuery( $query );

					$this->_data = $this->_getList( $query,$limitstart,  $limit);

					return $this->_data ;
			}
	  

	 function store($data)
		{ 
			
			$db = JFactory::getDBO();
			$row =& $this->getTable('mylisting');
			$data = JRequest::get( 'post' );
		    $id=JRequest::getVar('id');
		  //print_r($_POST);die;
		 
		    if($id)
		    {
			$row->id=$id;
		    }
			if (!$row->bind($data))
			{
				
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			$row->request_type_id=$request_type_id;
			
			if (!$row->check()) 
			{
				
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			// Store the  table to the database
			if (!$row->store()) 
			{
					
				 $this->setError($this->_db->getErrorMsg()); 
				return false;
			}
		
		return true;
		}
		
		public function delete()
	{
	      

			$b_id = JRequest::getVar('id');
			
			$row =& $this->getTable('mylisting');
			
			$row->delete($b_id);
		
		return true;

	}	
	 
}