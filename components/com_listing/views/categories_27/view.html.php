<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Jomcouponcategorys View
 */

class ListingViewCategories extends JView
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
		//print_r($this->items);die;
		$this->pagination = $pagination;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		
		JToolBarHelper::title(JText::_('CATEGORY MANAGER'));
		//JToolBarHelper::addNew('category.add');
		//JToolBarHelper::editList('category.edit');
		//JToolBarHelper::deleteList('', 'categories.delete');
	}

	
}
