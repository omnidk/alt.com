<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
//$row=Listinghelper::getDistinct('#__users','*','','loadObjectlist');
//print_r($row);die;
?>

<?php /*?> <tr>
 <td>
 <select name="credit">
 <option value="">-select-</option>
 <?php foreach($row as $row1){?>
 <option value="<?php echo $row1->id; ?>"><?php echo $row1->name; ?></option>
 <?php } ?>
 </select>
 </td>
 <td>
 Dates From:
 
 <?php echo JHTML::_('calendar','','startdate','startdate' ,'%Y/%m/%d',array('class'=>'inputbox', 'size'=>'20', 'maxlength'=>'25')); ?>
 T0:
 
 <?php echo JHTML::_('calendar','','enddate','enddate' ,'%Y/%m/%d',array('class'=>'inputbox', 'size'=>'20', 'maxlength'=>'25')); ?>
 <input type="hidden" name="pushed" value="pushed" />
 <input type="submit" value="GO" onclick="this.form.submit();"></td></tr> 
<tr><?php */?>
	
	<th><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
    <th><?php echo JText::_('Sender Name'); ?></th>
    <th><?php echo JText::_('Receiver Name'); ?></th>
    <th><?php echo JText::_('Total Amount'); ?></th>
    <th><?php echo JText::_('From Total Balance'); ?></th>
    <th><?php echo JText::_('From Line of Credit'); ?></th>
    <th><?php echo JText::_('Transaction Date'); ?></th>
</tr>

