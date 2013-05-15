<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php
     foreach($this->items as $i=> $item): ?>
        <?php if($item->parent_id==0) {?>
  <tr class="row<?php echo $i % 2; ?>">
   <td>
	<?php echo $item->id; ?>
  </td>
  <td>
	<?php echo JHtml::_('grid.id', $i, $item->id); ?>
  </td>
  <td >
     <a href="index.php?option=com_listing&task=category.edit&id=<?php echo $item->id;?>">
	 <?php echo '<big>'. $item->category.'</big>'; ?></a>
  </td>
  
  <td align="center">
     <?php echo JHtml::_('jgrid.published', $item->published, $i, 'categories.', 1);?>  
  </td>
  </tr>
      <?php } ?>
      <?php 
	  $row=ListingHelper::detail('#__barter_category','','*','parent_id',$item->id,'','loadObjectlist');
	  $j=1;
	  foreach($row as $row1)
	  {?>
  <tr>
  <td>
	  <?php echo $row1->id; ?>
  </td>
  <td align="center">
	 <?php  echo JHtml::_('grid.id','_b'.$item->id.'_'.$j, $row1->id); ?>
  </td>
  <td>
  
     <a href="index.php?option=com_listing&task=category.edit&id=<?php echo $row1->id;?>">
     <?php  echo str_repeat('<span class="gi">|&mdash;</span>',1); echo $row1->category; ?>
  </td>
 
  <td align="center">
     <?php echo JHtml::_('jgrid.published', $row1->published, '_b'.$item->id.'_'.$j, 'categories.', 1);?>  
  </td>
  </tr>
    <?php $j++; }?>
    <?php endforeach;  ?>

<style>
td
{ text-align:center;}
</style


