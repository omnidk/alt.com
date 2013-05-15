<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * HelloWorld component helper.
 */
abstract class MenuHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		
		/*JSubMenuHelper::addEntry(JText::_('HOME'),'index.php?option='.COM_LISTING);
		
		JSubMenuHelper::addEntry(JText::_('Account Manager '),'index.php?option='.COM_LISTING.'&view='.ACCOUNT,$submenu == 'Account');
		JSubMenuHelper::addEntry(JText::_('Listing Manager'),'index.php?option='.COM_LISTING.'&view='.LISTING_MANAGERS,$submenu == 'Listing Manager');
		JSubMenuHelper::addEntry(JText::_('Catagory Manager'),'index.php?option='.COM_LISTING.'&view='.CATEGORIES,$submenu == 'Category');
		JSubMenuHelper::addEntry(JText::_('User Manager'),'index.php?option='.COM_LISTING.'&view='.USERS,$submenu == 'Users');
		JSubMenuHelper::addEntry(JText::_('Transaction Manager'),'index.php?option='.COM_LISTING.'&view='.TRANSACTIONS,$submenu == 'Transaction');
		JSubMenuHelper::addEntry(JText::_('Invoice Manager'),'index.php?option='.COM_LISTING.'&view='.INVOICES,$submenu == 'Invoice');
		JSubMenuHelper::addEntry(JText::_('Transfer Credit'),'index.php?option='.COM_LISTING.'&view='.'broker',$submenu == 'Transfer Credir');
		*/
		
		$document = JFactory::getDocument();
		
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_(CATEGORY));
		}
		
	}
}