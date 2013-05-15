<?php
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$db	=& JFactory::getDBO();
$item_id	= JRequest::getInt('item_id');
$db->setQuery("SELECT l.id as id,
                          l.user_id as user_id,
													l.type as type,
                          l.listing_title as listing_title,
                          l.description as description,
                          l.homeurl as homeurl,
                          l.paystring as paystring,
                          l.sell_price as sell_price,
                          l.shipping_cost as shipping_cost,
                          l.quantity as quantity,
                          l.wishlist as wishlist,
                          l.start_date as start_date,
													l.end_date as end_date,
						  l.total_views as total_views,
						  l.offer_received as offer_received,
						  l.offer_approved as offer_approved,
						  u.name as seller_name
	               FROM #__barter_listing l
				   INNER JOIN #__users u ON u.id = l.user_id
				   WHERE published = 1 AND l.id = $item_id order by l.id");
	$rows = $db->loadObjectList();
	$listingType = $row->type;
	echo ListingHelper::topMenu();	
	$user =& JFactory::getUser();
	$user_id=$user->get('id');	
	//update total views
	$db->setQuery("UPDATE #__barter_listing SET total_views = total_views + 1  WHERE id = $item_id");
	$db->query();
	foreach($rows as $row)
	{
	?>
		<div class="listing">
			<h3><?php echo $row->listing_title; ?></h3>	
			<p><?php echo $row->description; ?></p>
			<table border="0" width="50%">
				<tr>
					<?php  
  				$listingType = $row->type;
  				switch($listingType){
  				case 1:
  				echo "<td><strong>Bartered Amount:</strong> $row->sell_price</td>";
					echo "<td><strong>Offers So Far:</strong> &nbsp;".$row->offer_received."/".$row->offer_approved."</td>";
  				break;
  				case 2:
  				echo "<td><strong>Bartered Amount:</strong> $row->sell_price</td>";
					echo "<td><strong>Offers So Far:</strong> &nbsp;".$row->offer_received."/".$row->offer_approved."</td>";
  				break;
  				case 3:
  				//run a query to find the highest bid
					$db->setQuery("SELECT MAX(amount) as highest FROM #__barter_listing_bids WHERE listing_id = $item_id");
					$db->query();
					$highBid = $db->loadAssoc();											
 					echo "<td><strong>Highest Bid:</strong>".$highBid['highest']."</td>";
					 // use to count total bids so far
					$db->setQuery("SELECT count(id) as total FROM #__barter_listing_bids WHERE listing_id = $item_id");
					$db->query();
					$totalbids = $db->loadAssoc();
					echo "<td><strong>Bids So Far:</strong> &nbsp;".$totalbids['total']."</td>";
  				break;
  				}

  				?>

				</tr>
				<tr>
					<td><strong>Shipping Cost:</strong> &nbsp;$<?php echo $row->shipping_cost; ?></td>
					<td><strong>Quantity:</strong> &nbsp;<?php echo $row->quantity; ?></td>
				</tr>
				<tr>
					<td><strong>Posted:</strong> &nbsp;<?php echo date('m.d.y',$row->start_date); ?></td>
					<td><strong>Viewed:</strong> &nbsp;<?php echo $row->total_views; ?></td>
				</tr>
				<?php  
				//$listingType = $row->type;
				//switch($listingType){
				//case 3:
				//echo $row->end_date;
				//echo "<tr><td><strong>Auction Ends:</strong> ".date('m.d.y',(int)$row->end_date)."</td></tr>";
				$timeLeft = time() - $row->end_date;
				$timeLeft = gmdate('H:i:s', $timeLeft);
				echo "<tr><td><strong>time left:</strong> ".$timeLeft."</td>";
				
				//see if there's any bids
        $db->setQuery("SELECT count(id) as total FROM #__barter_listing_bids WHERE listing_id = $item_id");
        $db->query();
        $totalbids = $db->loadAssoc();
        $bidcount = $totalbids['total'];
        //echo $bidcount; die;
        if($bidcount == 0){
				//do nothing
				}else{
				//echo "here"; 
					  $db->setQuery("SELECT MAX(amount) as highest FROM #__barter_listing_bids WHERE listing_id = $item_id");
            $db->query();
            $highBid = $db->loadAssoc();
            $highest = $highBid['highest'];
						$db->setQuery("SELECT * FROM #__barter_listing_bids WHERE listing_id = $item_id AND amount = $highest");
        		$db->query();
        		$highBid = $db->loadAssoc();
        		//$bidder_id = $highBid['bidder_id'];	
						$previousHighUID = $highBid['bidder_id'];
						$user =& JFactory::getUser($previousHighUID);
          	$highest_bidder = $user->username;    
						echo "<td><strong>Highest Bidder:</strong> ".$highest_bidder."</td>";			
				}

				echo "</tr>";
				//break;
				//}?>

				
				
			</table>	
			<?php
			if($user_id == $row->user_id)
			{
				?>
					<br />
					<table border="0" width="50%">
						<tr>
							<td>
								<a href="index.php?option=com_listing&view=mylistings&layout=editpost&listing_id=<?php echo $row->id; ?>">Edit the item</a>
							</td>
						</tr>
					</table>
				<br />
				<?php
			}
			elseif($user_id > 0)
			{
			//for now, show all functions: buy now, make offer, or bid
				//$listingType = $row->type;
				//echo $listingType;
				//switch($listingType){
				//case 1://show both offers and 'buy now' with trade credits
				//echo "type 1";
				?><form action="index.php?option=com_listing&view=browse&layout=createoffer" method="post" name="adminForm" enctype="multipart/form-data">
					<table border="0" width="50%">
						<tr>
							<td>
								<input type="text" name="desired_quantity" id="desired_quantity" value="1"> Desired Quantity
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" name="make_offer" id="make_offer" value="Click Here to Make an Offer">&nbsp;&nbsp;
								<input type="submit" name="make_offer" id="buy_now" value="Buy Now">
								<input type="hidden" name="item_id" value="<?php echo $row->id; ?>">
								
							</td>
						</tr>
					</table>
				</form>
				<?php
				//break;
				//case 2://show only 'buy now' for trade credits transfer
				//echo "type 2";
				?><!--<form action="index.php?option=com_listing&view=browse&layout=createoffer" method="post" name="adminForm" enctype="multipart/form-data">
					<table border="0" width="50%">
						<tr>
							<td>
								<input type="text" name="desired_quantity" id="desired_quantity" value="1"> Desired Quantity
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" name="make_offer" id="buy_now" value="Buy Now">
								<input type="hidden" name="item_id" value="<?php echo $row->id; ?>">
							<!--</td>
						</tr>
					</table>
				</form>-->
				<?php
				//break;
				//case 3://show the 'bid' button with an input box for 'bid amount'
				//echo "type 3";
				?><form action="index.php?option=com_listing&view=browse&layout=createbid" method="post" name="adminForm" enctype="multipart/form-data">
					<table border="0" width="50%">
						<tr>
							<td>
								Bid Amount: <input type="text" name="bid_amount" id="bid_amount" value="1"> 
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" name="create_bid" id="create_bid" value="Make Bid">
								<input type="hidden" name="item_id" value="<?php echo $row->id; ?>">
							</td>
						</tr>
					</table>
				</form>
				<?php
				//break;
				//}

			}
			?>	
			<br />
			<table border="0" width="50%">
				<tr>
					<td><strong>Seller:</strong></td>
					<td>
						<strong><?php echo $row->seller_name; ?></strong>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<?php
						//get user review info
						$db->setQuery("SELECT *
											 FROM #__barter_users_history
											 WHERE user_id = $row->user_id
											");
						$db->query();
						$userreview = $db->loadAssoc();
						if($userreview['total_reviews'] == 0)
						{
							?>
							<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $row->user_id; ?>">(0)</a> reviews with (New)100.00% positive
							<?php
						}
						else
						{
							$review_parcent = ($userreview['total_positive_reviews'] * 100)/$userreview['total_reviews'];
							?>
							<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $row->user_id; ?>">(<?php echo $userreview['total_reviews']; ?>)</a> reviews with <?php echo $review_parcent; ?>% positive
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $row->user_id; ?>"><strong>Read all Reviews</strong></a> | 
						<?php
						if($user_id == 0)
						{
							?>
							<a href="index.php?option=com_users&view=login">Login to Contact Seller</a>
							<?php
						}
						else
						{
							?>	
							<a href="index.php?option=com_listing&view=myaccount&layout=askquestion&seller_id=<?php echo $row->user_id; ?>&listing_id=<?php echo $row->id; ?>">Ask Seller a question</a> 
							<?php
						}
						//if not watched, offer to watch, if watched, offer to unwatch
						  $db->setQuery("SELECT count(id) as total FROM #__barter_listing_watching WHERE uid = $user_id AND listing_id = $item_id");
        $db->query();
        $watch = $db->loadAssoc();
        $watch = $watch['total'];
				//echo $watch;
				if($watch == 1){
				echo "<a href=\"index.php?option=com_listing&view=myaccount&layout=watching&do=unwatch&listing=".$item_id."\">Remove from Watchlist</a>";				
				}else{
				echo "<a href=\"index.php?option=com_listing&view=myaccount&layout=watching&do=watch&listing=".$item_id."\">Add to Watchlist</a>";
				}
						
						
						?>
						
					</td>
				</tr>
			</table> 		
			<br />
			<table border="0" width="50%">
				<tr>
					<td><strong>Payment:</strong></td>
					<td><?php echo $row->paystring; ?></td>
				</tr>
				<tr>
					<td><strong>Wishlist:</strong></td>
					<td><?php echo $row->wishlist; ?></td>
				</tr>
				<!--<tr>
					<td><strong>Website:</strong></td>
					<?php
function formatWebAddress($webAddress) {
	$originalWebAddress = $webAddress;
	$webAddress = "*" . $webAddress;
	$formattedWebAddress = "";
	if (stripos($webAddress, "http://") == 1) {	//starts with http://
		if (substr_count($webAddress, ".") == 1) {	//one dot only
			$formattedWebAddress = $originalWebAddress;
			$formattedWebAddress = insertString($formattedWebAddress, "www.", 7);
		}
		else
			$formattedWebAddress = $originalWebAddress;
	}
	else {	//does not start with http://
		if (substr_count($webAddress, ".") == 1)	//one dot only
			$formattedWebAddress = "http://www." . $originalWebAddress;
		elseif (substr_count($webAddress, ".") >= 2)	//two dots only
			$formattedWebAddress = "http://" . $originalWebAddress;
		else
			$formattedWebAddress = $originalWebAddress;
	}
	// add slash at end
	if (substr_count($formattedWebAddress, "/") == 2)	//if it has "//" at beginning
		$formattedWebAddress .= "/";
	$formattedWebAddress = strtolower($formattedWebAddress);
	return $formattedWebAddress;
}	
$homeurl = formatWebAddress($row->homeurl);
?>
					<td><a href="<?php echo $homeurl; ?>" target="_blank"><?php echo $homeurl; ?></a></td>
				</tr>-->
				<tr>
				<td style="padding:10px;"><a href="index.php?option=com_listing&view=browse&layout=userslistings&seller_id=<?php echo $row->user_id; ?>">View all listings from <?php echo $row->seller_name; ?></a></td>
				</tr>
			</table>
		</div>	



	<?php



	}