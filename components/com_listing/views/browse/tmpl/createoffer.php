<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$db	=& JFactory::getDBO();
	$item_id = JRequest::getInt('item_id');
	$desired_quantity = JRequest::getInt('desired_quantity');
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
	?>
		<div class="listing">
			<div>You are making an offer on <?php echo $desired_quantity; ?> of Item Number <?php echo $item_id; ?>, <b><?php echo $rows['listing_title']; ?></b></div>
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
			<form action="index.php?option=com_listing&view=browse&layout=offersave&type=1" method="post" name="adminForm" enctype="multipart/form-data">
				<fieldset class="adminform">
					<table class="admintable">
						<tbody>
							<tr>
								<td class="key">
									<label for="message">Amount of Trade Credits to include,</label>
								</td>
							</tr>
							<tr>
								<td>
									<input class="inputbox" type="text" name="amount_of_trade_credits" onblur="roundit('amount_of_trade_credits')" id="amount_of_trade_credits" size="40" value="" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="message">Amount of Cash to include,</label>
								</td>
							</tr>
							<tr>
								<td>
									<input class="inputbox" type="text" name="amount_of_cash" onblur="roundit('amount_of_cash')" id="amount_of_cash" size="40" value="" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="message">Type comments to the Seller in this box</label>
								</td>
							</tr>
							<tr>
								<td>
									<textarea id="comments" name="comments" cols="30" rows="5"></textarea>
								</td>
							</tr>
							<tr>
								<td>
								  <input type="hidden" name="type" value="1">
									<input type="submit" name="submit" value="Make Offer">
									<input type="hidden" name="desired_quantity" value="<?php echo $desired_quantity; ?>">
									<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
									
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
			</form>
			<?php
			}
			?>
		</div>