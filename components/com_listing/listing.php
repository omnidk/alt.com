<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'globalMain.php'); 

JLoader::register('ListingHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'listing.php');

JLoader::register('MenuHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'menu.php');

// Get an instance of the controller prefixed by HelloWorld
 $controller = JController::getInstance('listing'); 
//echo 'hiiii';die; 
// Perform the Request task

 $controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
