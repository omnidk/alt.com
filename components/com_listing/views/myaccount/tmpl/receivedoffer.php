<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php /*?><?php echo ListingHelper:: userMenu();<?php */?>
<?php echo ListingHelper::topMenu(); ?>
<?php
  $user =& JFactory::getUser();
	$user_id=$user->get('id');
	$db	=& JFactory::getDBO();
	$db->setQuery("SELECT lo.id as id,
                          lo.listing_id as listing_id,
                          lo.offered_by as offered_by,
													lo.type as type,
													lo.is_parent as is_parent,
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
				   WHERE lo.offered_to = $user_id AND lo.is_archived_by_seller = 0 AND lo.type = 1");
	$rows = $db->loadObjectList();
	?>
	<div class="listing">
		<div class="right">
		<h2>Received Offers</h2>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th>ID</th>
						<th>Buyer Name</th>
						<th>Item Title</th>
						<th>Desired Quantity </th>
						<th>Trade Credits </th>
						<th>Cash</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="items">
					<?php $i=1;
						foreach($rows as $row)
						{
							?>
							<tr id='post-102' class='alternate'>
							<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
							<td class="centeralign"><?php echo $row->buyer_name; ?></td>
							<td class="centeralign"><a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $row->listing_id; ?>"><?php echo $row->listing_title; ?></a></td>
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
			
			<h2>Negotiations</h2><?php
$db->setQuery("SELECT lo.id as id,
													lo.type as type,
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
				   WHERE lo.offered_to = $user_id AND lo.is_archived_by_seller = 0 AND lo.type = 2");
$rows = $db->loadObjectList();
	?>
			
			
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th>ID</th>
						<th>From</th>
						<th>Item Title</th>
						<th>Desired Quantity </th>
						<th>Trade Credits </th>
						<th>Cash</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="items">
					<?php $i=1;
						foreach($rows as $row)
						{
							?>
							<tr id='post-102' class='alternate'>
							<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
							<td class="centeralign"><?php echo $row->buyer_name; ?></td>
							<td class="centeralign"><a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $row->listing_id; ?>"><?php echo $row->listing_title; ?></a></td>
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
		</div>	
		<div class="clear"></div>
	</div>		


