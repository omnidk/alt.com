<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
//echo '<pre>';
//print_r($this->items);
$i=0;
?><h3>You can set/update user balance click on 'Name'</h3>
<?php foreach($this->items as $i => $item): ?>
    
	<tr class="row<?php echo $i % 2; ?>">
          <td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
         <td>
            <a href="index.php?option=com_listing&task=user.edit&id=<?php echo $item->id;?>">
			<?php echo $item->name ; ?></a>
        
        </td>
        <td> 
       
		 <?php 			
		 //$broker_id = $item->broker_id; 
		// print_r( $broker_id );die;
		 //$brokernames = JFactory::getUser($broker_id);
		//$brokername = $item->broker_id;
		 $brokername = ListingHelper::detail('#__users','','username','id',$item->broker_id,'','loadresult'); 
		 
		?>
        <a href="index.php?option=com_listing&task=user.edit&id=<?php echo $item->id;?>">
          <?php echo $brokername ; ?>
       <?php /*?> <?php echo $item->username ; ?><?php */?>
		<?php //echo $brokername; ?>
		</td>
        <td><?php echo $item->email; ?></td>
        <td><?php echo $item->total_balance; ?></td>
        <td><?php echo $item->line_of_credit; ?></td>
        <td><?php echo $item->total_reviews; ?></td>
        <td>
        	<?php
        	if($item->status == '1') echo "<b>Block</b>"; 
        	if($item->status == '0') echo "<b>ok</b>";
        	?>
        </td>
      
   </tr>
<?php endforeach; ?>


<style>
td
{ text-align:center;}
</style>