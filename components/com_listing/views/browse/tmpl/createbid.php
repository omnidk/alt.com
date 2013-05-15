<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$db	=& JFactory::getDBO();
	$item_id = JRequest::getInt('item_id');
	$bid_amount = JRequest::getFloat('bid_amount');
	$db->setQuery("SELECT l.id as id,
                          l.user_id as user_id,
                          l.listing_title as listing_title,
                          l.description as description,
                          l.homeurl as homeurl,
                          l.paystring as paystring,
                          l.sell_price as sell_price,
                          l.shipping_cost as shipping_cost,
                          l.quantity as quantity,
                          l.start_date as start_date,
						  l.total_views as total_views,
						  u.name as seller_name,
						  u.username as username,
						  u.email as seller_email
	               FROM #__barter_listing l
				   INNER JOIN #__users u ON u.id = l.user_id
				   WHERE published = 1 AND l.id = $item_id order by l.id");
	$rows = $db->loadAssoc();
	echo ListingHelper::topMenu();
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	$my_dup_row2 = array( 'item_id' => $item_id, 'desired_quantity' => $desired_quantity);
	$session =& JFactory::getSession();
	$session->set('my_dup_row2', $my_dup_row2);

	//see if there's any bids
	$db->setQuery("SELECT count(id) as total FROM #__barter_listing_bids WHERE listing_id = $item_id");
	$db->query();
	$totalbids = $db->loadAssoc();
	$bidcount = $totalbids['total'];
	//echo $bidcount; die;
	if($bidcount == 0){
			//if not, make sure bid is higher than starting price
			$sell_price = $rows['sell_price'];			
			//echo $sell_price; die;
			if($bid_amount <= $sell_price){
				$message = "Bid needs to be higher than the starting price.";
			}	
	}else{	
    	//make sure the bid amount is higher than the highest bid for this item
    	//if there are no bids, make sure it's higher than the starting price
    	$db->setQuery("SELECT MAX(amount) as highest FROM #__barter_listing_bids WHERE listing_id = $item_id");
    	$db->query();
    	$highBid = $db->loadAssoc();
    	$highest = $highBid['highest'];	
    	if($bid_amount <= $highest){
    		$message = "Bid needs to be higher than the last highest bid.";
			}
	}
	//confirm new bid, then do bidsave.php
	if($message == ""){
	?>
		<div class="listing">
			<div>You are making a bid of <?php echo $bid_amount; ?> on Item # <?php echo $item_id; ?>, <b><?php echo $rows['listing_title']; ?></b></div>
			<?php
			if($_POST['make_offer'] == 'Buy Now')
			{
				die(header('Location: index.php?option=com_listing&view=browse&layout=buynow'));
			}
			else
			{
			?>
			<script>
				function roundit(x){
					var amount = document.getElementById(x).value;
					var newAm = Math.round(amount);
					document.getElementById(x).value = newAm;
				}
			</script>
			<form action="index.php?option=com_listing&view=browse&layout=bidsave" method="post" name="adminForm" enctype="multipart/form-data">
				<fieldset class="adminform">
					<table class="admintable">
						<tbody>
							<tr>
								<td>
									<input type="submit" name="submit" value="Confirm Bid">
									<input type="hidden" name="bid_amount" value="<?php echo $bid_amount; ?>">
									<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
			</form>
			<?php
			}}
			echo $message;
			
			?>
		</div>
<?php //end ?>