<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Jomcouponcategorys View
 */
class ListingViewTransactions extends JView
{
	/**
	 * Jomcoupons view display method
	 * @return void
	 */

	function display($tpl = null) 
	{
		
			
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 
		// Set the toolbar
		//$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		
		
	}
 
	/**
	 * Setting the toolbar
	 */
/*?>protected function addToolBar() 
	{
		
		JToolBarHelper::title(JText::_('Transactions Manager'), 'coupon48x48.png');
		//JToolBarHelper::addNewX('listing_manager.add');
		//JToolBarHelper::editListX('listing_manager.edit');
		//JToolBarHelper::custom('listing_managers.publish', 'publish.png', 'publish_f2.png','publish', true);
		//JToolBarHelper::custom('listing_managers.unpublish', 'unpublish.png', 'unpublish_f2.png', 'unpublish', true);
		//JToolBarHelper::deleteListX('', 'listing_managers.delete');
		//JToolBarHelper::custom('listing_managers.close', 'home32x32', 'home32x32','Home',false);
		//JToolBarHelper :: custom( 'coupons.cpanel', 'cpanel.png', 'cpanel.png', 'Cpanel', true);
	}<?php */
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	
}
