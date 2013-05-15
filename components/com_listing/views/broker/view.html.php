<?php
defined('_JEXEC') or die('Restrict Access');
jimport('joomla.application.component.view');
class ListingViewBroker extends JView
 {
   function __construct()
 {
   parent::__construct();
   }
   
  function display($tpl=null)
   {     
   
   				JToolBarHelper::title(JText::_('Broker Manager'),'generic.png' );
				
				//$total = & $this->get( 'Total');
				
				//$pagination = $this->get('pagination');
				
				$broker=& $this->get('data');
				
				
				//print_r($showdonation);

				//$this->pagination = $pagination;

				$this->assignRef('broker',$broker);
  		 		parent::display($tpl);

   } 

 }    



?>

