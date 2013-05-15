<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
  $item_id = JRequest::getInt('item_id');
  $type = JRequest::getInt('type'); //echo $type; die;
  $parent = JRequest::getInt('parent');
	$desired_quantity = JRequest::getInt('desired_quantity');
	$amount_of_trade_credits = JRequest::getFloat('amount_of_trade_credits');
	$amount_of_cash = JRequest::getFloat('amount_of_cash');
	$comments = JRequest::getString('comments');
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
	$seller_id = $rows['user_id'];
	$listing_title = $rows['listing_title'];
	$quantity = $rows['quantity'];
	
	//get this users info - the one who is sending the offer/or counter-offer as it were
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	$username=$user->get('username');
	
	//echo $type; die;

	if($type == '1'){//it's a regular offer

  	$typeword = "offer";
  	$offerTo = $seller_id;//seller
  	$offerFrom = $user_id;//buyer
  	$memberRole = "Buyer";
		$buyer_id = $user_id;
	
	}elseif($type == '2'){//it's a counter offer

  		$typeword = "counter-offer";
  		//$notify = //could be buyer or seller.. it's the user who isn't logged in...	
  		if($user_id == $seller_id){//sending user is the seller,
  			//so send it to the buyer (check parent)
  			$db->setQuery("SELECT buyer FROM  #__barter_listing_offer WHERE id = $parent limit 0,1");
      	$rows3 = $db->loadAssoc();
      	//print_r( $rows3['offered_by']);die;
  			$offerTo = $rows3['buyer'];//get this from db
  			$offerFrom = $seller_id;
				$buyer_id = $rows3['buyer'];
				//echo $parent;
				//echo "buyer in parent offer ".$buyer_id; die;
  			$memberRole = "Seller";//for this member

  		}else{//sending user is the buyer
  			$offerTo = $seller_id;
  			$offerFrom = $user_id;
				$buyer_id = $user_id;
  			$memberRole = "Buyer";	//for this member

  		}
	}
	//echo $typeword; die;
	//echo $quantity; echo $listing_title; echo $item_id; die;
	
	echo ListingHelper::topMenu();
	//print_r( $rows );die;
	$db->setQuery("SELECT email FROM  #__users WHERE id = $user_id limit 0,1");
	$rows2 = $db->loadAssoc();
	//print_r( $rows['quantity']);die;
	?>
		<div class="listing">
			<?php
			if($success == 1)
			{ 
				echo "<h2 class=\"error\">Your ".$typeword." sent successfully!</h2>";
			}
			else
			{
				if($desired_quantity <= 0)
				{
					?>
					<h2 class="error">Error! Did you ask for more than the posted quantity available? Please click <a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $item_id; ?>">this link</a> to make new offer.</h2>
					<?php
				}
				elseif($desired_quantity > $rows['quantity'])
				{
					?>
					<h2 class="error">Sorry! your desired quantity[<?php echo $desired_quantity; ?>] is greater than stock[<?php echo $rows['quantity']; ?>]. Please click <a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $item_id; ?>">this link</a> to make new offer.</h2>
					<?php
				}
							
				else
				{
				//echo "buyer=".$buyer_id;
				//echo "seller=".$seller_id; //die;
					$db->setQuery("INSERT INTO #__barter_listing_offer SET id = '', type='".$type."', parent='".$parent."',listing_id='" . $item_id . "', offered_by='" . $offerFrom . "', offered_to='" . $offerTo . "', seller='".$seller_id."',buyer='".$buyer_id."', desired_quantity='" . $desired_quantity . "', amount_of_trade_credits='" . $amount_of_trade_credits . "', amount_of_cash='" . $amount_of_cash . "', comments='" . $comments . "', status='pending', created_date='" . date('Y-m-d H:m:s') . "', is_reviewed_by_seller='0', is_reviewed_by_buyer='0'");
					$db->query();
					//update offer received
					$db->setQuery("UPDATE #__barter_listing SET offer_received = offer_received + 1  WHERE id = $item_id");
					$db->query();
					//update 'is_parent' of the parent offer
					$db->setQuery("UPDATE #__barter_listing_offer SET is_parent = 1, is_archived_by_seller = 1, is_archived_by_buyer = 1 WHERE id = $parent");
					$db->query();
					//update 'rejected' of the parent offer
					$db->setQuery("UPDATE #__barter_listing_offer SET status = 'rejected' WHERE id = $parent");
					$db->query();
					

		//notify the one who got the offer (seller) or counter offer (could be buyer or seller)					 		
		$mailer =& JFactory::getMailer();
		$config =& JFactory::getConfig();
    $sender = array( 
        $config->getValue( 'config.mailfrom' ),
        $config->getValue( 'config.fromname' ) );
		$sitename =& $config->getValue( 'config.sitename' );
		$livesite =& $config->getValue( 'config.live_site' );
		$offered_by = $rows['offered_by'];
		$listing_title = $rows['listing_title'];
		$user =& JFactory::getUser($offerTo);//for the other members info
    $recipient = $user->email;     
    $mailer->addRecipient($recipient);
		$mailer->setSubject(''.$username.' has sent you a '.$typeword.'.');
		$emailBody = "<table border='0'>
									<tr>
										<td>$memberRole: $username</td>
									</tr>
									<tr>
										<td>Item No: $item_id</td>
									</tr>
									<tr>
										<td>Item Title: $listing_title</td>
									</tr>
									<tr>
										<td>Desired Quantity: $desired_quantity</td>
									</tr>
									<tr>
										<td>Amount of Cash: $amount_of_cash</td>
									</tr>
									<tr>
										<td>Amount of Trade Credits: $amount_of_trade_credits</td>
									</tr>
									<tr>
										<td>Comment: $comments</td>
									</tr>
									<tr>
										<td><BR />GOTO > myaccount > received offers <a href=\"".$livesite."\">".$sitename."</a></td></tr></table>";
    $mailer->isHTML(true);
    $mailer->Encoding = 'base64';
    $mailer->setBody($emailBody);
		$mailer->setSender($sender);//Global Configuration -> Server -> Mail Settings
		$send =& $mailer->Send();
    if ( $send !== true ) {
        //echo 'Error sending email: ' . $send->message;
    } else {
        //echo 'Mail sent';
				echo "<h2 class=\"error\">Your ".$typeword." sent successfully!</h2>";
					//header("Location: index.php?option=com_listing&view=browse&layout=offersave&success=1");
		}



				}
			}
			?>


