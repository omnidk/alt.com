<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
	$token = JRequest::getString('token');
	$payerid = JRequest::getInt('PayerID');
	$db	=& JFactory::getDBO();
	$account = "SELECT * FROM #__barter_account limit 0,1";
	$db->setQuery($account);
	$account_detail = $db->loadAssoc(); 
	$payerID = urlencode("$payerid");
	$token   = urlencode("$token");
	$final=$account_detail;
	//if ($final)
	//{
		$session =& JFactory::getSession();
		$my_dup_row2 = $session->get('my_dup_row2');
		$db	=& JFactory::getDBO();
		$item_id          = $my_dup_row2['item_id'];	
		$desired_quantity = $my_dup_row2['desired_quantity'];	
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
		$total_cost = ($desired_quantity*$rows['sell_price'])+$rows['shipping_cost'];
		//get seller id
		$seller_id = $rows['user_id'];
		$listing_title = $rows['listing_title'];
		
		$user =& JFactory::getUser();
		$user_id=$user->get('id');
		$username=$user->get('username');

				//insert transaction history
				$db->setQuery("INSERT INTO #__barter_users_transfer_history  SET id = '', amount='" . $total_cost . "', from_total_balance='" . $from_total_balance . "', from_line_of_credit='" . $from_line_of_credit . "', sender_id='" . $user_id . "', receiver_id='" . $seller_id . "', comments='" . $listing_title . "', created_date='" . date('Y-m-d H:m:s') . "'");
				$db->query();
				
				//substract from sender user
				$db->setQuery("UPDATE #__barter_users_history SET total_balance = total_balance - $total_cost,line_of_credit = line_of_credit WHERE user_id = $user_id");
				$db->query();
				
				//added in receiver user
				$db->setQuery("UPDATE #__barter_users_history SET total_balance = total_balance + total_balance + $total_cost,line_of_credit = line_of_credit WHERE user_id = $seller_id");
				$db->query();
				
				//send email
			/*	$emailBody = "<table border='0'>
							<tr>
								<td>Sender Name: $sendername</td>
							</tr>
							<tr>
								<td>Amount: $amount</td>
							</tr>
							<tr>
								<td>Comment: $comments</td>
							</tr>
						  </table>
						 ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				mail($receiverinfo['receiver_email'], "$sendername sent you credit!", $emailBody, $headers);
*/
		
		
		$db->setQuery("INSERT INTO #__barter_listing_offer SET id = '', listing_id='" . $item_id . "', offered_by='" . $user_id . "', offered_to='" . $rows['user_id'] . "', desired_quantity='" . $desired_quantity . "', amount_of_trade_credits='" . $total_cost . "', amount_of_cash='0', comments='" . $comments . "', status='accepted', created_date='" . date('Y-m-d H:m:s') . "', is_reviewed_by_seller='0', is_reviewed_by_buyer='0'");
		$db->query();
		//update offer approved
		$db->setQuery("UPDATE #__barter_listing SET offer_approved = offer_approved + 1  WHERE id = $item_id");
		$db->query();
		$offer = "SELECT * FROM #__barter_listing_offer ORDER BY id DESC limit 0,1";
		$db->setQuery($offer);
		$offer_detail = $db->loadAssoc(); 
		$offer_id = $offer_detail['id'];
		header("Location: index.php?option=com_listing&view=myaccount&layout=offerview&offer_id=$offer_id");
		//}
?>
