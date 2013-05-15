<?php 
//No direct access
defined('_JEXEC') or die('Restricted Access');

//import joomla control library
jimport('joomla.application.component.controller');
require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'mylisting.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'myaccount.php');
class ListingControllerMyaccount extends JController
{
	function display($tpl=null)

		{
		  die('STOP');
		  JRequest::setVar( 'view', 'myaccount' );
		  parent::display();

		}
	function inbox()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','inbox' );
		
				  parent::display();
		}
		function messagedetails()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','messagedetails' );
		
				  parent::display();
		}
		function sentmessage()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','sentmessage' );
		
				  parent::display();
		}
		
	   function messagereplay()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','messagereplay' );
		
				  parent::display();
		}
		function offerview()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','offerview' );
		
				  parent::display();
		}
		function receivedoffer()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','receivedoffer' );
		
				  parent::display();
		}
		function archivedoffer()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','archivedoffer' );
		
				  parent::display();
		}
		function salescredits()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','salescredits' );
		
				  parent::display();
		}
		function purchasecredits()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','purchasecredits' );
		
				  parent::display();
		}
	
	   function receivedcredits()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','receivedcredits' );
		
				  parent::display();
		}
		function sentcredits()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','sentcredits' );
		
				  parent::display();
		}
		function transfer()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','transfer' );
		
				  parent::display();
		}
		function cash2credits()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','cash2credits' );
		
				  parent::display();
		}
		
		function invoices()
		{

				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','invoices' );
		
				  parent::display();
		}
		function cash2credits2()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','cash2credits2' );
		
				  parent::display();
		}
		function reviews()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','reviews' );
		
				  parent::display();
		}
		function askquestion()
		{
		
				JRequest::setVar( 'view', 'myaccount' );
				JRequest::setVar( 'layout','askquestion' );
		
				  parent::display();
		}
	function save() 
	  {  
				
			$model = $this->getModel('myaccount');
					//print_r($_POST);die;						
			if($model->store($_POST))
			{
			
				$msg = JText::_('Request Was Successfully save');
			
			}
			else
			{
			
				$msg = JText::_('Error In Request Sending');
			
			}
			
			$link = 'index.php?option=com_listing&view=myaccount';
			
			$this->setRedirect($link, $msg);		

	  }
	  function save1() 
	  {  
				
			$model = $this->getModel('myaccount');
					//print_r($_POST);die;						
			if($model->store1($_POST))
			{
			
				$msg = JText::_('Request Was Successfully save');
			
			}
			else
			{
			
				$msg = JText::_('Error In Request Sending');
			
			}
			
			$link = 'index.php?option=com_listing&view=myaccount';
			
			$this->setRedirect($link, $msg);		

	  }
}