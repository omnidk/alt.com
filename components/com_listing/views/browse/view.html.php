<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');


class ListingViewBrowse extends JView
{
	/**
	 * display method
	 * @return void
	 */
	public function display($tpl = null)
	{
		// get the Data


		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data


		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
}