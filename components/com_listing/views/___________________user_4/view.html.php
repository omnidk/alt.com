<?php

/**
 * @version		$Id: view.html.php 51 2010-11-22 01:33:21Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorld View
 */
class ListingViewUser extends JView
{
	/**
	 * display method of Hello view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
	
		
		$item = $this->get('Item');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{   
	   
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->user_id == 0);
		JToolBarHelper::title($isNew ? JText::_('Add') : JText::_('Edit'),'category48x48.png');
	  
	  $layout=JRequest::getVar('layout');
if($layout=='user_add' || 'new'){
}else{ 	
	   JToolBarHelper::apply('user.apply', 'JTOOLBAR_APPLY');
	   JToolBarHelper::save('user.save');
		}	
		//JToolBarHelper::cancel('user.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}
