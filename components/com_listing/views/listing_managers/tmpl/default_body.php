<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 


?>
<?php foreach($this->items as $i => $item): ?>

	<tr class="row<?php echo $i % 2; ?>">
       
        <td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
        <td>
        <a href="index.php?option=com_listing&task=listing_manager.edit&id=<?php echo $item->id;?>">
			<?php echo $item->listing_title ; ?></a>
        
        </td>
        <td><?php echo $item->sell_price ; ?></td>
        <td><?php echo $item->quantity; ?></td>
        <td><?php echo JHtml::_('jgrid.published', $item->published, $i, 'listing_managers.', 1);?> </td>
        <td><?php echo $item->id; ?></td>
   </tr>
<?php endforeach; ?>


<style>
td
{ text-align:center;}
</style>