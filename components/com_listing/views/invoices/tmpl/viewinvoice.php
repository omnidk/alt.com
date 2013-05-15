<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
$user =& JFactory::getUser();



	$user_id=$user->get('id');

	

	$invoiceID = JRequest::getInt('invoiceID');



	?>



	<div class="listing">



	

	<div class="right">



			<div class="right">



			<h2>Invoice #<?php echo $invoiceID; ?></h2>



				<table class="wide" style="width:550px;"><?php						



		$database 	= & JFactory::getDBO();



		$database->setQuery("SELECT * FROM #__barter_invoices WHERE ndx = $invoiceID");



		$database->query();



		$rows = $database->loadObjectList();



					foreach($rows as $invoice)



					{



						$user_id = $invoice->uid;



						}



			$username = $user->get('username');



		?>



				<thead>                            



					<tr>



						<th scope="col">T. ID</th>



						<th nowrap="nowrap" class="title"><a href="index.php?option=com_listing&task=sentcredits&order_by=<?php echo $order_by1; ?>" style="float:left;">Date and Time</a></th>



						<th nowrap="nowrap" class="title">To</th>



						<th nowrap="nowrap" class="title">Comment</th>



						<th nowrap="nowrap" class="title">Amount</th>



					</tr>



				</thead>



				<tbody id="items">



					<?php 		



						//get all their received transactions from last month



						//process each users transfer history for last month



        		$database->setQuery("SELECT * FROM #__barter_users_transfer_history WHERE sender_id = $user_id AND brokered = 1");



						//needs - WHERE receiver_id = user_id AND it's from last month!



        		$database->query();



        		$rows = $database->loadObjectList();



        					foreach($rows as $row)



        					{



      						$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));



      						$month_torun = date('m',$lastmonth);



      						$year_torun = date('Y',$lastmonth);      						



              		$due_date = mktime(0, 0, 0, date("m"), date("d")+30, date("Y"));



              		$due_date_formatted = date("m.d.y",$due_date);



              		$todays_date = time();



              		$today_formatted = date("m.d.y");



									//here check the date



									$timestamp = $row->created_date;



									$timestamp = strtotime($timestamp);										



									$month = date('m',$timestamp);



									$year = date('Y',$timestamp);									



									if(($month == $month_torun) && ($year == $year_torun)) {



											//run the invoice maker													



											$rid = $row->receiver_id; 



											$receiverUser = JFactory::getUser($rid);



											?>



											<tr id='post-102' class='alternate'>



												<td class="tdfixedwidth"><?php echo $row->id; ?></td>



												<td><?php echo $row->created_date;?></td>



												<td><?php echo $receiverUser->username; ?></td>



												<td><?php echo $row->comments; ?></td>



												<td><?php echo $row->amount; ?></td>



											</tr>



											<?php



											//calculate the commission and add it to $total_due



											$commission = ($row->amount*$account_detail['comission_percent'])/100;



											//echo $commission;



											$total_due = $total_due + $commission;



											//$total_due = $total_due + $row->amount;



									}



						}



						



					?>	



				</tbody>



			</table><?php	



			echo "<h3 style=\"padding:9px;background:#E3DEE0; border:1px solid #A69FA1; width:530px;\">";



if($invoice->paid != 1){



$button = "1";



echo "Total Due: ";



}else{



echo "Paid:";



}



 echo $invoice->amt;



if($button == "1"){



?>



<div style="position:relative; float:right; top:-3px;"><form action="index.php?option=com_listing&task=payinvoice" method="post" name="adminForm" enctype="multipart/form-data"><input type="hidden" name="invoiceID" value="<?php echo $invoiceID; ?>" /><input type="hidden" name="amt" value="<?php echo $invoice->amt; ?>" /><input type="submit" name="submit" value="Pay"></form></div>



<?php 



}