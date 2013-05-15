<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo "<p><a href=\"index.php?option=com_listing&view=invoices&layout=generateInvoice\">Generate Invoices</a> - Click here the first of each month.</p>";
	?>

<?php foreach($this->items as $i => $item): ?>
   <?php   $user_id = $item->uid;?>
	<tr class="row<?php echo $i % 2; ?>">
         <td>
     <?php /*?><?php  $ndx = $item->ndx; echo "<a href=\"index.php?option=com_listing&view=invoices&layout=viewInvoice&invoiceID=".$ndx."\">".$user_id->ndx."</a>"; ?><?php */?>
        <?php echo  $item->ndx;?>
        </td>
        <td>
        
      <?php /*?>  <a href="index.php?option=com_listing&task=useredit&user_id=<?php echo $user_id;?>" title="Edit User"><?php */?>
									
	  <?php 
      //$s = $item->uid; 
      //$user3 = JFactory::getUser($s);
       $item->uid;
      echo ListingHelper::detail('#__users','','username','id',$item->uid,'','loadresult');
      
       ?>
      
		
		</td>
        <td><?php $month = $item->month;
				  $month =ListingHelper::GetMonthString($month);
		          echo $month; ; ?></td>
        <td><?php echo "$";echo $item->amt;; ?></td>
        <td><?php 
				  if($item->paid == 1){
				  echo "x";
				  }?>; </td>
        <td><?php 
			if($item->paidDate != 0){
			echo $item->paidDate;
			 }?></td>
      
   </tr>
<?php endforeach; ?>


<style>
td
{ text-align:center;}
</style>