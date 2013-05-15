<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$database 	= & JFactory::getDBO();
		$ftransac = false;
		//get account info
		$account = "SELECT * FROM #__barter_account limit 0,1";
		$database->setQuery($account);
		$account_detail = $database->loadAssoc();

		//$x = $account_detail['comission_percent'];
		//echo $x;

		//get a list of users involved in the barter component
		$database->setQuery("SELECT u.id as user_id,
                                    u.name as full_name,
									u.email as email,
                                    uh.total_balance as total_balance,
									uh.line_of_credit as line_of_credit,
                                    uh.total_reviews as total_reviews									
		                     FROM #__users u 
							 LEFT JOIN #__barter_users_history uh ON uh.user_id = u.id
							");
		$database->query();
		$num_rows = $database->getNumRows();
		$rows = $database->loadObjectList();
		if(count($rows) > 0)

		{
			//loop through the user_ids and
			foreach($rows as $user)
			{
				$user_id = $user->user_id;
				$username = ListingHelper::detail('#__users','','username','id','user_id','','loadresult');
				//$username = JFactory::getUser($user_id);
				//$username = $username->username;
				//here loop through the transactions from this user from last month
				//if they had any
				$database->setQuery("SELECT * FROM #__barter_users_transfer_history WHERE sender_id =". $user_id. " AND brokered = 1");
				//needs - WHERE from last month!
				if ($database->query()){
					$num_rows = $database->getNumRows();
				}
				else{
					$num_rows = 0;
				}
				
				if($num_rows>0)
				{
					if (!$ftransac){
						$ftransac = true;
					}
					//order by
					$order_by = $_REQUEST['order_by'];
					if($order_by == '')
					{
						$order_by  = 'desc';
						$order_by1 = 'asc';
					}
					else
					{
						if($order_by == 'asc')
						{
							$order_by1 = 'desc';
						}
						else
						{
							$order_by1 = 'asc';
						}
					}
					?>
<div
	style="border: 2px solid #cccccc; border-top: 3px solid #666666; padding: 10px; margin-bottom: 10px; width: 550px;">
	<table class="adminlist">
		<thead>
			<tr>
				<th scope="col">Transaction ID</th>
				<th nowrap="nowrap" class="title"><a
					href="index.php?option=com_listing&task=sentcredits&order_by=<?php echo $order_by1; ?>"
					style="float: left;">Date and Time</a>
				</th>
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
		if ($rows){
			foreach($rows as $row)
			{
				//gotta figure out how to get all the transactions from last month..

				//make date(m)-1 for last month, take out -1 for this month for testing
				$lastmonth = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
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
					//convert receiver_id to receiver_username
					$rid = $row->receiver_id;
					$receiverUser = JFactory::getUser($rid);
					?>
			<tr id='post-102' class='alternate'>
				<td class="centeralign tdfixedwidth"><?php echo $row->id; ?>
				</td>
				<td class="centeralign"><?php echo $row->created_date;?>
				</td>
				<td class="centeralign"><?php echo $receiverUser->username; ?>
				</td>
				<td class="centeralign"><?php echo $row->comments; ?>
				</td>
				<td class="centeralign"><?php echo $row->amount; ?>
				</td>
			</tr>
			<?php
			//calculate the commission and add it to $total_due
			$commission = ($row->amount*$account_detail['comission_percent'])/100;
			//echo $commission;
			$total_due = $total_due + $commission;
			//$total_due = $total_due + $row->amount;
				}
			}
		}
		?>
		</tbody>
	</table>
	<?php
	//if total due is bigger than zero, add to db and send invoice notification
	if($total_due > 0){
		//select all invoices for this user for last month
		$database->setQuery("SELECT * FROM #__barter_invoices WHERE uid = '$user_id' AND month = '$month'");
		$database->query();
		$num_rows = $database->getNumRows();
		if($num_rows == 0)
		{
			//if none, insert the invioice for last month
			//this adds new invoice to db
			$database->setQuery("INSERT INTO #__barter_invoices SET uid = '$user_id', amt='$total_due', month='$month'");
			$database->query();
			$msg = "Invoice Sent";
		}else{
			$msg = "Invoices were already sent for this month.";
		}
	}
	echo "<h3 style=\"padding:9px;background:#E3DEE0; border:1px solid #A69FA1; width:530px;\">Member: "; echo $username; echo " | Total Due: "; echo $total_due; echo " | ".$msg."</h3></div>";
				}
			}
		}
		if (!$ftransac) {
			echo 'No transactions were found for last month';
		}
	

	