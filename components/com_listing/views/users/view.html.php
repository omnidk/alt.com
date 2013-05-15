<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Jomcouponcategorys View
 */
class ListingViewUsers extends JView
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
		
		JToolBarHelper::title(JText::_('User Manager'), 'coupon48x48.png');
		//JToolBarHelper::addNewX('user.add');
		JToolBarHelper::editListX('user.edit');
		//JToolBarHelper::Back();
		//JToolBarHelper::custom('users.publish', 'publish.png', 'publish_f2.png','publish', true);
		//JToolBarHelper::custom('users.unpublish', 'unpublish.png', 'unpublish_f2.png', 'unpublish', true);
		JToolBarHelper::deleteListX('', 'users.delete');
		//JToolBarHelper::custom('users.close', 'home32x32', 'home32x32','Home',false);
		//this one was funky (to add a whole new user to joomla too??) so we can leave it out
		//JToolBarHelper :: custom( 'user.add', 'new.png', 'new.png', 'Add User', false,false);
		JToolBarHelper :: custom( 'user.user_add', 'new.png', 'new.png', 'Add User', false,false);
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	
}
