<?php  
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

 class ListingControllerMylisting extends JControllerForm
 {
	public function save()
	{
		// Check for request forgeries.
		// Initialise variables.
		
		$model	= $this->getModel('mylisting');
		
		// Get the user data.

		$requestData = JRequest::getVar('jform', array(), 'post', 'array');
		
		// Validate the posted data.
		$form	= $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		$data	= $model->validate($form, $requestData);

		// Attempt to save the data.
		$return	= $model->store($data);
		
		// Check for errors.
		if ($return === false) {
			
			// Redirect back to the edit screen.
			$this->setMessage(JText::sprintf('Data not saved', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_listing'));
			return false;
		}
		else{
			$this->setMessage(JText::sprintf('Data save'));
			$this->setRedirect(JRoute::_('index.php?option=com_listing'));
		}
	}	
 }