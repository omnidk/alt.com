<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

  
<tr>
	
	<th><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
    <th><?php echo JText::_('Name'); ?></th>
    <th><?php echo JText::_('Broker'); ?></th>
    <th><?php echo JText::_('Email'); ?></th>
    <th><?php echo JText::_('Total Balance'); ?></th>
    <th><?php echo JText::_('Line of Credit'); ?></th>
    <th><?php echo JText::_('Total Reviews'); ?></th>
    <th><?php echo JText::_('Status'); ?></th>
</tr>

