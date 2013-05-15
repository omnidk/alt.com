<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
 $user =& JFactory::getUser();
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
?>
<?php
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	echo ListingHelper::topMenu();
	$db	=& JFactory::getDBO();
	$db->setQuery("SELECT lo.id as id,
                          lo.listing_id as listing_id,
                          lo.offered_by as offered_by,
                          lo.desired_quantity as desired_quantity,
                          lo.amount_of_trade_credits as amount_of_trade_credits,
                          lo.amount_of_cash as amount_of_cash,
                          lo.comments as comments,
                          lo.created_date as created_date,
                          lo.status as status,
                          lo.is_reviewed_by_seller as is_reviewed_by_seller,
                          lo.is_reviewed_by_buyer as is_reviewed_by_buyer,
						  l.listing_title as listing_title,
						  u.name as buyer_name
	               FROM #__barter_listing_offer lo
				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id
				   INNER JOIN #__users u ON u.id = lo.offered_by
				   WHERE lo.offered_to = $user_id AND lo.is_archived_by_seller = 1");
	$archived = $db->loadObjectList();
	//print_r($archived );die;
	$db->setQuery("SELECT lo.id as id,
                         lo.listing_id as listing_id,
                          lo.offered_by as offered_by,
                          lo.desired_quantity as desired_quantity,
                          lo.amount_of_trade_credits as amount_of_trade_credits,
                          lo.amount_of_cash as amount_of_cash,
                          lo.comments as comments,
                          lo.created_date as created_date,
                          lo.status as status,
                          lo.is_reviewed_by_seller as is_reviewed_by_seller,
                          lo.is_reviewed_by_buyer as is_reviewed_by_buyer,
						  l.listing_title as listing_title,
						  u.name as seller_name
	               FROM #__barter_listing_offer lo
				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id
				   INNER JOIN #__users u ON u.id = lo.offered_to
				   WHERE lo.offered_by = $user_id AND lo.is_archived_by_buyer = 1");
	$sent = $db->loadObjectList();
		?>
        
	<div class="listing">
		<div class="right">
			<h2>Received Offer</h2>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th scope="col">ID</th>
						<th scope="col">Buyer Name</th>
						<th scope="col">Item Title</th>
						<th scope="col">Desired Quantity </th>
						<th scope="col">Trade Credits </th>
						<th scope="col">Cash</th>
						<th scope="col">Status</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody id="items">
					<?php //$i=$start+1;
					    $i=1;
						foreach($archived as $row)
						{
							?>
							<tr id='post-102' class='alternate'>
							<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
							<td class="centeralign"><?php echo $row->buyer_name; ?></td>
							<td class="centeralign"><?php echo $row->listing_title; ?></td>
							<td class="centeralign"><?php echo $row->desired_quantity; ?></td>
							<td class="centeralign"><?php echo $row->amount_of_trade_credits; ?></td>
							<td class="centeralign"><?php echo $row->amount_of_cash; ?></td>
							<td class="centeralign"><?php echo $row->status; ?></td>
						<td class="centeralign"><a href="index.php?option=com_listing&view=myaccount&layout=offerview&offer_id=<?php echo $row->id; ?>" rel="permalink">View</a></td>
					</tr>
						<?php
						$i++;
						}
					?>	
				</tbody>
			</table>
			<br />
			<h2>Sent Offer</h2>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
				<th scope="col">ID</th>
						<th scope="col">Seller Name</th>
					<th scope="col">Item Title</th>
					<th scope="col">Desired Quantity </th>
					<th scope="col">Trade Credits </th>
				<th scope="col">Cash</th>
				<th scope="col">Status</th>
				<th scope="col"></th>
			</tr>
	</thead>
	<tbody id="items">
		<?php //$i=$start+1;
		      $i=1;
			foreach($sent as $row)
						{
				?>

			<tr id='post-102' class='alternate'>
								<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
						<td class="centeralign"><?php echo $row->seller_name; ?></td>
					<td class="centeralign"><?php echo $row->listing_title; ?></td>
					<td class="centeralign"><?php echo $row->desired_quantity; ?></td>
					<td class="centeralign"><?php echo $row->amount_of_trade_credits; ?></td>
				<td class="centeralign"><?php echo $row->amount_of_cash; ?></td>
				<td class="centeralign"><?php echo $row->status; ?></td>
								<td class="centeralign"><a href="index.php?option=com_listing&task=offerview&offer_id=<?php echo $row->id; ?>" rel="permalink">View</a></td>
							</tr>
				<?php
				$i++;
						}
					?>	
				</tbody>
			</table>