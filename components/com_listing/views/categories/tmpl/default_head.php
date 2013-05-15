<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
  <th width="15"><?php echo JText::_('ID'); ?></th>
	<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
   <th><?php echo JText::_('Category Name'); ?></th>
    <th><?php echo JText::_('Published'); ?></th>
</tr>

