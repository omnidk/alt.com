<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
//echo 'hiiiiiiiiii';die; 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
//include(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'category.php');

class ListingModelUser extends JModelAdmin
{
        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       1.6
         */
	
	
        public function getTable($type = 'user', $prefix = 'ListingTable', $config = array()) 
        {
		       
        	return JTable::getInstance($type, $prefix, $config);
				
        }
        /**
         * Method to get the record form.
         *
         * @param       array   $data           Data for the form.
         * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
         * @return      mixed   A JForm object on success, false on failure
         * @since       1.6
         */
        public function getForm($data = array(), $loadData = true) 
		{
		$form = $this->loadForm('com_listing.user', 'user', array('control' => 'jform', 'load_data' => $loadData));
		//print_r($form);
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
        /**
         * Method to get the data that should be injected in the form.
         *
         * @return      mixed   The data for the form.
         * @since       1.6
         */
		 
        protected function loadFormData() 
        {
			
                // Check the session for previously entered form data.
                //echo 'HELLLO 3 <br>';
                $data = JFactory::getApplication()->getUserState('com_listing.edit.user.data', array());
               				
                if (empty($data)) 
                {
                        $data = $this->getItem();
						
                
				}
                return $data;
        }
	
		
}
