<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorlds View
 */
class ListingViewListing extends JView
{
	/**
	 * HelloWorlds view display method
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
	 public function cpanelIcon( $image , $url , $text , $newWindow = false )
	{
		$newWindow	= ( $newWindow ) ? 'target="_blank"' : '';
?>
		<div style="float:left;">
			<div class="icon">
				<a href="<?php echo $url; ?>" <?php echo $newWindow; ?>>
					<img alt="" src="<?php echo JC_ADMINIMAGE_FOLDER.'/logos/'.$image?>">
					<span><?php echo $text ?></span>
				</a>
			</div>
		</div>
<?php

	}
	
	protected function addToolBar() 
	{
		JToolBarHelper::title( JText::_('Barter and Trade') );
	}
	
	
	
}	?>
