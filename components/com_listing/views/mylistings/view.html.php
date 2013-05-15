<?php 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 

class ListingViewMylistings extends JView
{
	/**
	 * display method 
	 * @return void
	 */
	/*	 
		 function __construct()
	   {
		parent::__construct();
	    }
	*/
	function display($tpl = null) 
	{
	   
		$items=& $this->get('data');
		// print_r($items);die;
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
 
		// Display the template
		parent::display($tpl);
	}
 
	/**
	 * Setting the toolbar
	 */
}