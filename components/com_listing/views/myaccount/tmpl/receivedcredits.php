<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
?>
<?php
 $user =& JFactory::getUser();
	$user_id=$user->get('id');
	$db	=& JFactory::getDBO();
	//order by
	$order_by = JRequest::getWord('order_by');
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
	//sent credits info
	$db->setQuery("SELECT th.id as id,
                          th.amount as amount,
                          th.from_total_balance as from_total_balance,
                          th.from_line_of_credit as from_line_of_credit,
                          th.sender_id as sender_id,
                          th.comments as comments,
                          th.created_date as created_date,
						  u.name as seller_name
	               FROM #__barter_users_transfer_history th
				   INNER JOIN #__users u ON u.id = th.sender_id
				   WHERE th.receiver_id = $user_id
				   ORDER BY th.created_date $order_by
				   ");
	$received = $db->loadObjectList();
	//get user info
	$db->setQuery("SELECT u.id as user_id,
								u.name as full_name,
								u.email as email,
								uh.total_balance as total_balance,
								uh.line_of_credit as line_of_credit,
								uh.total_reviews as total_reviews									
						 FROM #__users u 
						 LEFT JOIN #__barter_users_history uh ON uh.user_id = u.id
						 WHERE u.id = $user_id
						");
	$db->query();
	$userinfo = $db->loadAssoc();
	?>
	<div class="listing">
		<div class="right">
			<p>Your Current Balance is $<?php echo $userinfo['total_balance']; ?> and you have a line of credit to the amount of $<?php echo $userinfo['line_of_credit']; ?></p>
			<p><a href="index.php?option=com_listing&view=myaccount&layout=transfer"><strong>Do you want to transfer balance?</strong></a></p>
			<br />
			<h2>Received Credits</h2>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th scope="col">Transaction ID</th>
						<th scope="col"><a href="index.php?option=com_listing&task=receivedcredits&order_by=<?php echo $order_by1; ?>">Date & Time</a></th>
						<th scope="col">From</th>
						<th scope="col">Comment</th>
						<th scope="col">Amount</th>
					</tr>
				</thead>
				<tbody id="items">
					<?php $i=1;
						foreach($received as $row)
						{
							?>
							<tr id='post-102' class='alternate'>
								<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
								<td class="centeralign"><?php echo $row->created_date; ?></td>
								<td class="centeralign"><?php echo $row->seller_name; ?></td>
								<td class="centeralign"><?php echo $row->comments; ?></td>
							<td class="centeralign"><?php echo $row->amount; ?></td>
						</tr>
						<?php
						$i++;
						}
					?>	
				</tbody>
		</table>
	</div>	
	<div class="clear"></div>
	</div>	

