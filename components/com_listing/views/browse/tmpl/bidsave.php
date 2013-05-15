<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
  $item_id = JRequest::getInt('item_id');
	$bid_amount = JRequest::getInt('bid_amount');

	//if success
	$success = JRequest::getBool('success');
	$db	=& JFactory::getDBO();
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
						  u.email as seller_email
	               FROM #__barter_listing l
				   INNER JOIN #__users u ON u.id = l.user_id
				   WHERE published = 1 AND l.id = $item_id order by l.id");
	$rows = $db->loadAssoc();	
	$listing_title = $rows['listing_title'];
	
	echo ListingHelper::topMenu();
	//print_r( $rows );die;
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	$bidder_id=$user_id;
	$username=$user->get('username');
	$db->setQuery("SELECT email FROM  #__users  WHERE id = $user_id limit 0,1");
	$rows2 = $db->loadAssoc();
	//print_r( $rows['quantity']);die;
	?>
		<div class="listing">
			<?php
			if($success == 1)
			{ 
				?>
				<h2 class="error">You are now the highest bidder!</h2>
				<?php
			}
			else
			{
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
      					//check again to see if anyone else has made a higher bid before this one made it in..
              	$db->setQuery("SELECT MAX(amount) as highest FROM #__barter_listing_bids WHERE listing_id = $item_id");
              	$db->query();
              	$highBid = $db->loadAssoc();
              	$highest = $highBid['highest'];	
              	if($bid_amount <= $highest){
              		$message = "Someone else must have just placed a bid higher than yours. Try again.";	
					}
			}
					
					echo $message;
					//if message is blank, proceed wih bid entry
					if($message == ""){
					//now email the previous high bidder and tell them that they've been outbid
        	$db->setQuery("SELECT * FROM #__barter_listing_bids WHERE listing_id = $item_id AND amount = $highest");
        	$db->query();
        	$highBid = $db->loadAssoc();
        	//$bidder_id = $highBid['bidder_id'];	
					$previousHighUID = $highBid['bidder_id'];
					//get their email
					if($previousHighUID == ""){
					//do nothing
					}else{//email previous high bidder
					//echo "here";
					//echo $previousHighUID;die;
					$mailer =& JFactory::getMailer();
					$config =& JFactory::getConfig();
          $sender = array( 
              $config->getValue( 'config.mailfrom' ),
              $config->getValue( 'config.fromname' ) );
           
          $mailer->setSender($sender);//Global Configuration -> Server -> Mail Settings
					
          // -> addRecipient          
          $user =& JFactory::getUser($previousHighUID);
          $recipient = $user->email;           
          $mailer->addRecipient($recipient);
					$mailer->setSubject('You\'ve been outbid');
					$body   = '<h2>Someone has bid higher than you!</h2>'
              . '<div>Your bid on auction item # '.$item_id.'  ('.$listing_title.')has been outdone-'
              . 'You may wish to place a higher bid.</div>';
          $mailer->isHTML(true);
          $mailer->Encoding = 'base64';
          $mailer->setBody($body);
					$send =& $mailer->Send();
          if ( $send !== true ) {
              echo 'Error sending email: ' . $send->message;
          } else {
              //echo 'Mail sent';
          }					
					}//end if $previoushighUID == ""
					
					//enter the bid and give success message
					$timestamp = time();
					$db->setQuery("INSERT INTO `#__barter_listing_bids` (`id`, `listing_id`, `bidder_id`, `amount`, `timestamp`) VALUES (NULL, $item_id, $user_id, $bid_amount, $timestamp)");
					$db->query() or die;
					//update offer received -> this will show on /browse/items as bids recieved
					$db->setQuery("UPDATE #__barter_listing SET offer_received = offer_received + 1  WHERE id = $item_id");
					$db->query();					
					header("Location: index.php?option=com_listing&view=browse&layout=bidsave&success=1");
					}
			}
			
			?>