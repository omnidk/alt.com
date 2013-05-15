<?php
//No direct Access
defined('_JEXEC') or die('Restricted Access');

//import joomla modelform library
jimport('joomla.application.component.model');
//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');

class ListingModelPost extends JModel
{
	 function __construct()
	  {
	   parent::__construct();
	  }

}