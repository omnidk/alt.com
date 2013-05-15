<?php 
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

require_once(JPATH_COMPONENT.DS.'tables'.DS.'mylisting.php');
class ListingModelMylisting extends JModelAdmin
{
	
	public function getTable($type = 'mylisting', $prefix = 'ListingTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true) 
	{
	
		// Get the form.
		//echo 'sssssss';die;
		$form = $this->loadForm('com_listing.mylisting', 'mylisting', array('control' => 'jform', 'load_data' => $loadData));
		//$form = $this->loadForm('com_listing.mylisting', 'mylisting', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{ 
		
			return false;
		}
		
		
		return $form;
	}
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('mylisting.edit.mylisting.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
			//print_r($data);die;
		}
		//print_r($data);die;
		return $data;
	}
	
	
	function _buildQuery()
				
			{
				
			$array = JRequest::getVar('cid',  0, '', 'array');
			$id = (int)$array[0];
			$user=JFactory::getUser();
		    $query = 'SELECT * FROM #__barter_listing';
			return $query;
						
			}
	
	function getData() 
	{
		// if data hasn't already been obtained, load it
		
		if (empty($this->_data)) {
		$query = $this->_buildQuery();
		$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
		}
		return $this->_data;
	}
	
	function getTotal()
						{
							
						// Load the content if it doesn't already exist
						if (empty($this->_total)) 
						{    
						$query = $this->_buildQuery();
						$this->_total = $this->_getListCount($query);    
						}
						return $this->_total;
						}

	protected function getListQuery()
	{
		// Create a new query object.
		//echo 'sssssss';die;
		$id=JRequest::getVar('id');	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		// From the hello table
		 $query->from('#__barter_listing');
		//$query->where('id=1'); 
		return $query;
	}
}