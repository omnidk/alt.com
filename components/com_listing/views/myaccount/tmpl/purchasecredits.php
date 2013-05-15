<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
?>
<?php
  $user =& JFactory::getUser();
	$user_id=$user->get('id');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
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
	$db	=& JFactory::getDBO();
	$db->setQuery("SELECT lo.id as id,
                          lo.listing_id as listing_id,
                          lo.offered_by as offered_by,
                          lo.desired_quantity as desired_quantity,
                          lo.amount_of_trade_credits as amount_of_trade_credits,
                          lo.amount_of_cash as amount_of_cash,
                          lo.created_date as created_date,
						  l.listing_title as listing_title,
						  u.name as seller_name
	               FROM #__barter_listing_offer lo
				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id
				   INNER JOIN #__users u ON u.id = lo.offered_to
				   WHERE lo.offered_by = $user_id AND lo.status = 'accepted'
				   ORDER BY lo.created_date $order_by
				   ");
	$purchased = $db->loadObjectList();
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
			<h2>Purchased History</h2>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th scope="col">Transaction ID</th>
						<th scope="col"><a href="index.php?option=com_listing&task=purchasecredits&order_by=<?php echo $order_by1; ?>">Date & Time</a></th>
						<th scope="col">To</th>
						<th scope="col">Item Title</th>
						<th scope="col">Trade Credits </th>
						<th scope="col">Cash</th>
					</tr>
				</thead>
				<tbody id="items">
					<?php $i=1;
						foreach($purchased as $row)
						{
							?>
							<tr id='post-102' class='alternate'>
								<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
								<td class="centeralign"><?php echo $row->created_date; ?></td>
								<td class="centeralign"><?php echo $row->seller_name; ?></td>
								<td class="centeralign"><?php echo $row->listing_title; ?></td>
								<td class="centeralign"><?php echo $row->amount_of_trade_credits; ?></td>
								<td class="centeralign"><?php echo $row->amount_of_cash; ?></td>
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


