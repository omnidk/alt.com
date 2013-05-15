<?php
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
   $user =& JFactory::getUser();
   $user_id=$user->get('id');
	$sendername=$user->get('username');
	$db	=& JFactory::getDBO();
	echo ListingHelper::topMenu();
	//get token and payerid
	//$token = JRequest::getString('token');
//	$payerid = JRequest::getInt('PayerID');
	//print_r($payerid);die;
	//$payerID = urlencode("$payerid");
//	$token   = urlencode("$token");		
	//require_once('components/com_listing/paypal.php');
	//require_once('components/com_listing/httprequest.php');
	//$r = new PayPal(TRUE);
	//$final = $r->doPayment($token,$payerID);
	
	//if ($final['ACK'] == 'Success')
	if ($sendername)
	{
		$session =& JFactory::getSession();
		$my_dup_row = $session->get('my_dup_row');
		$amount   = $my_dup_row['amount'];
		$username = $my_dup_row['username'];
		$comments = $my_dup_row['comments'];
		//print_r($comments);die;
		$db->setQuery("SELECT `comission_percent` from #__barter_account");
		$db->query();
		$commission = $db->loadResult();
		$tax_estimate = ($amount / 100) * $commission;
		
		$amount_tax= $amount+ $tax_estimate ;
		
		//print_r($commission);die;
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
		$total_balance_and_line_credit = $userinfo['total_balance'] + $userinfo['line_of_credit'];
		if($total_balance_and_line_credit > $amount_tax)
		{
			//get receiver info
			$db->setQuery("SELECT u.id as user_id,
								  u.email as receiver_email	
								 FROM #__users u 
								 WHERE u.username = '$username'
								");
			$db->query();
			$receiverinfo = $db->loadAssoc();
			$receiver_id  = $receiverinfo['user_id'];
			if($receiver_id == '')
			{
				echo "Sorry! We have no found this username.";
			}
			else
			{
				if($amount_tax > $userinfo['total_balance'])
				{
					$from_total_balance  = $userinfo['total_balance'];
					$from_line_of_credit = $amount_tax - $userinfo['total_balance'];
				}
				else
				{
					$from_total_balance  = $amount_tax;
					$from_line_of_credit = 0;
				}
				
				
				 
				//print_r($amount_tax);die;
                 // ceil($tax_estimate); 
				//insert transaction history
				$db->setQuery("INSERT INTO #__barter_users_transfer_history  SET id = '', amount='" . $amount_tax . "', from_total_balance='" . $from_total_balance . "', from_line_of_credit='" . $from_line_of_credit . "', sender_id='" . $user_id . "', receiver_id='" . $receiver_id . "', comments='" . $comments . "', created_date='" . date('Y-m-d H:m:s') . "'");
				$db->query();
				//substract from sender user
				$db->setQuery("UPDATE #__barter_users_history SET total_balance = total_balance - $from_total_balance,line_of_credit = line_of_credit WHERE user_id = $user_id");
				$db->query();
				//added in receiver user
				$db->setQuery("UPDATE #__barter_users_history SET total_balance = total_balance + total_balance + $amount_tax,line_of_credit = line_of_credit WHERE user_id =    $receiver_id");
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
				?>
				<div class="listing">
					<div class="right">
						Offer successfully sent!
					</div>
					<div class="clear"></div>
				</div>
                
				<?php
			}
		}
		else
		{
			echo "Sorry! you have no available credit.";
		}
	}
	else
	{
		die(header('Location: index.php?option=com_listing&view=myaccount&layout=transfer'));

	}


