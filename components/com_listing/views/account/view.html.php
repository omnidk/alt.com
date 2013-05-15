<?php defined('_JEXEC') or die('Restricted access'); // No direct access to this file

jimport('joomla.application.component.view'); // import joomla view library
class ListingViewAccount extends JView
{   
	public function display($tpl = null) // call display
	{
		

		// Get data from the model
		//$items = $this->get('Items');
		
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
       //$this->items = $items;
				
		$this->addToolBar();
	    // Display the template
		parent::display($tpl);
	}
	
	protected function addToolBar() 
	{   
	   
		JToolBarHelper::title(JText::_('Account Manager'), 'coupon48x48.png');
		//JToolBarHelper::custom( 'account.accountupdates', 'save.png', 'save.png', 'Save', false,  false );
		//JToolBarHelper::save();
	}	
}
?>