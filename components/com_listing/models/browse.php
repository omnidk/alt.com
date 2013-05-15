<?php
//No direct Access
defined('_JEXEC') or die('Restricted Access');

//import joomla modelform library
jimport('joomla.application.component.model');
//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');

class ListingModelBrowse extends JModel
{

     var $_data = null;
	 var $_total=null;

	 function __construct()
	  {
	   parent::__construct();
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



	 function store()
		{

			$db = JFactory::getDBO();
			$row =& $this->getTable('mylisting');
			$data = JRequest::get( 'post' );

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