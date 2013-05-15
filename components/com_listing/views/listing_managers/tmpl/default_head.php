<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

  
<tr>
	
	<th><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
    <th><?php echo JText::_('Title'); ?></th>
    <th><?php echo JText::_('sell price'); ?></th>
    <th><?php echo JText::_('Quantity'); ?></th>
    <th><?php echo JText::_('Published'); ?></th>
    <th><?php echo JText::_('ID'); ?></th>
</tr>

