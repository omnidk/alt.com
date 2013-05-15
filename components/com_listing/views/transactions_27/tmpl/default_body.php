<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 

require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php

 foreach($this->items as $i => $item): ?>

	<tr class="row<?php echo $i % 2; ?>">
       
         <td>
        <?php 
		//$sender_id = $item->sender_id;
		//$sender =& JFactory::getUser($sender_id);
		 $item->sender_id; ?>
         <?php echo $user_name = ListingHelper::detail('#__users','','username','id',$item->sender_id,'','loadresult'); ?>
	    </td>
        <td>
		 <?php 			
		//$receiver_id = $item->receiver_id;
		//$receiver =& JFactory::getUser($receiver_id);
	   $item->receiver_id; ?>
        <?php echo $user_name = ListingHelper::detail('#__users','','username','id',$item->receiver_id,'','loadresult'); ?>
		</td>
        <td><?php //$broker_total = $broker_total + $item->amount;
								echo $item->amount; ?></td>
        <td><?php echo $item->from_total_balance; ?></td>
        <td><?php echo $item->from_line_of_credit; ?></td>
        <td><?php echo $item->created_date; ?></td>
      
   </tr>
<?php endforeach; ?>


<style>
td
{ text-align:center;}
</style>