<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
 $user =& JFactory::getUser();
 $user_id=$user->get('id');
	if($user_id == 0)
	{  
	$msg = JText::_( "Please login....");
			$redirectUrl = base64_encode("index.php?option=com_listing&view=mylistings");
			$version = new JVersion;
            $joomla = $version->getShortVersion();
            if(substr($joomla,0,3) == '1.5'){
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);
            }else{
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);    
            }
			JFactory::getApplication()->redirect($link, $msg);
	 }
	?>
<?php
  $user=& JFactory::getUser();
	$user_id = $user->get('id');
	ListingHelper::checkLoggedInUser();
	echo ListingHelper::topMenu();
	$db	=& JFactory::getDBO();	
	//get all listing using user_id
	//$db->setQuery("SELECT * FROM #__barter_listing WHERE user_id = $user->id");
	//$listing = $db->loadObjectList();
  $db->setQuery("SELECT * FROM #__barter_listing_bids WHERE bidder_id = $user_id");
  //$db->query();
  $bids = $db->loadObjectList();
	//$bids = $db->loadResultArray();
  //$bidder_id = $highBid['bidder_id'];	
	//$biddingon = $highBid['bidder_id'];
	//$bids = array_unique($bids);
	//var_dump($bids);
	?>
	<div class="listing">
	<h2>Bidding On:</h2>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
					<th scope="col">ID</th>
					<th scope="col">Title</th>
					<th scope="col">Quantity</th>
          <th scope="col">Wishlist</th>
					<th scope="col">Price</th>
					<th scope="col">Highest Bid</th>
					<th scope="col">Highest Bidder</th>
					<th scope="col">Auction Ends</th>
				</tr>
			</thead>
			<tbody id="items">
				<?php $i=1;
				
					$i=1;
	$myarray = array();
	foreach($bids as $row){

			//echo $row->listing_id;
			$listing_id = $row->listing_id;
			array_push($myarray, array('listing_id' => $listing_id));
			//echo "<br />";	
	}	
	$myarray = array_unique($myarray);	
	//echo '<pre><code>';
	//var_dump($myarray);
	//echo '</code></pre>'; die;
	foreach($myarray as $data){	
	//echo $data['listing_id'];
	$item_id = $data['listing_id'];
	//now grab the data for this listing and present
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
	$listing = $db->loadObjectList();
					foreach($listing as $row)
					{
						?>
						<tr id='post-102' class='alternate'>
							<td class="centeralign tdfixedwidth">
							<?php echo $row->id; ?>
							</td>
							<td class="centeralign"><a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $row->id; ?>"><?php echo $row->listing_title; ?></a></td>
							<td class="centeralign"><?php echo $row->quantity; ?></td>
              <td class="centeralign"><?php echo $row->wishlist; ?></td>
							<td class="centeralign"><?php echo $row->sell_price; ?></td>
							<td class="centeralign"><?php
							$db->setQuery("SELECT MAX(amount) as highest FROM #__barter_listing_bids WHERE listing_id = $item_id");
              	$db->query();
              	$highBid = $db->loadAssoc();
              	$highest = $highBid['highest'];	echo $highest; ?></td>
						  <td class="centeralign"><?php
							$db->setQuery("SELECT * FROM #__barter_listing_bids WHERE listing_id = $item_id AND amount = $highest");
        			$db->query();
        			$highBid = $db->loadAssoc();
        			//$bidder_id = $highBid['bidder_id'];	
							$previousHighUID = $highBid['bidder_id'];
							$user =& JFactory::getUser($previousHighUID);
          		$highest_bidder = $user->username;    
							echo $highest_bidder;							
							?></td>
							<td class="centeralign"><?php 
							echo date('m.d.y',$row->end_date);
							//$timeLeft = time() - $row->end_date;
							//$timeLeft = gmdate('H:i:s', $timeLeft);
							//echo $row->end_date; ?></td>
						</tr>
						<?php
						$i++;
					}
					}
				?>	
			</tbody>
		</table>
	</div>
