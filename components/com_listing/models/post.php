<?php 
//No direct Access
defined('_JEXEC') or die('Restricted Access');

//import joomla modelform library
jimport('joomla.application.component.model');
//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');

class ListingModelPost extends JModel
{	
	 function __construct()
	  {
	   parent::__construct();
	  }
	  

	 function store()
		{ 
			
			$db = JFactory::getDBO();
			$user =& JFactory::getUser();
	    $user_id=$user->get('id');	
		  //$d= date('Y-m-d H:m:s');
			//print_r($d);die;
			$row =& $this->getTable('post');
			$data = JRequest::get( 'post' );
  		/* Get proper HTML-code for your HTML-encoded field now by using JREQUEST_ALLOWHTML*/
  		$data['description']=JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );
			$row->start_date = time();
			$data['end_date']=strtotime($data['end_date']);
			//print_r($data);die;
			$row->user_id = $user_id;
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
	 
}