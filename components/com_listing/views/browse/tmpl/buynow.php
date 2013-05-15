<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
	$session =& JFactory::getSession();
	$my_dup_row2 = $session->get('my_dup_row2');
	$db	=& JFactory::getDBO();
	$item_id          = $my_dup_row2['item_id'];
	//print_r($my_dup_row2);die;	
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
	//make sure buyer has enough credits available
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
		
	  if($total_balance_and_line_credit < $amount)//if there isn't enough in thier account
	  {
				echo "<html><head><title>"._MSG_CANCELLED."</title></head><body><h3>"._MSG_PAYMENT_CANCELLED."</h3>";
			  echo "</body></html>";		
		}else{
		//run the transaction
	//make sure seller has an active account
	
	
	//get account info
	$account = "SELECT * FROM #__barter_account limit 0,1";
	$db->setQuery($account);
	$account_detail = $db->loadAssoc(); 
	$commission = ($total_cost*$account_detail['comission_percent'])/100;
	$tax_total=$total_cost+$commission;
   $rf=JRequest::getVar('submit');
	//echo $rf;die;
	 $user =& JFactory::getUser();
	$user_email=$user->get('email');
	$transaction_comment = $account_detail['payment_title'];
	
		if($commission > 0)
		{  
			require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.class.php');
			$p = new paypal_class;
			
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';  
	
	   $this_script 		= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=browse&layout=successbuy';

	 $this_script_cancal = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount';
	 
	 $this_script_successbuy = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=successbuy';
		
		
		//$paypal_email=$user_email;
			$act = JRequest::getVar('amount');
			
        // print_r($item_id);die;
		if (!empty($item_id)) { $item_id = 'process'; } 

//$ar = explode("$",$array_maile[1]);		 

		 switch ($item_id) 

		{

		   case 'process':      // Process and order...
			 
			  //$p->add_field('business', $paypal_email);
				$p->add_field('business', $account_detail['paypal_api_username']);
				$p->add_field('item_title', $account_detail['payment_title']);     
			  //$p->add_field('return', $this_script.'&action=success');//needs to go to successbuy.php
				$p->add_field('return', $this_script_successbuy);//needs to go to successbuy.php
			  $p->add_field('cancel_return', $this_script_cancal.'&action=cancel');
			  $p->add_field('notify_url', $this_script.'&action=ipn');			  
			  $p->add_field('currency_code','USD');
			  $p->add_field('amount',$tax_total);			  
				//$p->add_field('item_number',$lastid);			  
				//$p->add_field('tax', $total_tax);
			  $p->submit_paypal_post(); // submit the fields to paypal
			  //$p->dump_fields();      // for debugging, output a table of all the fields

			  break;

		   case 'success':      // Order was successful..

			 die(header('Location: index.php?option=com_listing&view=browse&layout=successbuy'));
			  //echo "<html><head><title>"._MSG_SUCCESS."</title></head><body><h3>"._MSG_THANKYOU."</h3>";

			  break;

		   case 'cancel':       // Order was canceled...

			  // The order was canceled before being completed.

			  echo "<html><head><title>"._MSG_CANCELLED."</title></head><body><h3>"._MSG_PAYMENT_CANCELLED."</h3>";
			  echo "</body></html>";
			  break;			  

		   case 'ipn':          // Paypal is calling page for IPN validation...

			  if ($p->validate_ipn()) 
			  {
				 // For this example, we'll just email ourselves ALL the data.

				 $subject = 'Photofix - Instant Payment Notification - Recieved Payment';

			//	 $to = $email;   ;//  your email

				 $body =  "An instant payment notification was successfully recieved\n";

				// $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');

				 $body .= " at ".date('g:i A')."\n\nDetails:\n";

				 foreach ($p->ipn_data as $key => $value) 
				 { 

						switch ($key) 
						{
							case "invoice":
							 	 $invoice = $value;

								 $body .= " Booking Reference: ".$value."\r\n";
								break;

							case "payer_id":
								$paypal_ref = $value;

								$body .= " Payer ID: ".$value."\r\n";
								break;

							case "mc_gross":
								$totalpaid = $value;

								$body .= " Total Paid: ".$value."\r\n";
								break;

						//	case "payer_email":
								

							////	$body .= " Payer Email: ".$email."\r\n";
							//	break;

						}

					} 

			  }

			  break;
	

}
			//$varurl = JURI::base();
			//$return_url = "$varurl"."index.php?option=com_listing&view=browse&layout=successbuy";
			//$r->setReturnUrl($return_url);
			//set username
			//$transaction_comment = $account_detail['payment_title'];
			//$ret = ($r->doExpressCheckout($commission, "$transaction_comment",rand(10,1000),'USD'));
		}
		else
		{
		//echo "heremm"; die;
		//redirect to successbuy??
		

		header("Location: index.php?option=com_listing&view=browse&layout=successbuy");
		
				echo "hererr"; die;
				
		
		
			//run the trade credit transaction for 'buy now'
			$user =& JFactory::getUser();
			$user_id=$user->get('id');
			$username=$user->get('username');
			
			
			//insert new offer, approved, 
			$db->setQuery("INSERT INTO #__barter_listing_offer SET id = '', listing_id='" . $item_id . "', offered_by='" . $user_id . "', offered_to='" . $rows['user_id'] . "', desired_quantity='" . $desired_quantity . "', amount_of_trade_credits='" . $total_cost . "', amount_of_cash='0', comments='" . $comments . "', status='accepted', created_date='" . date('Y-m-d H:m:s') . "', is_reviewed_by_seller='0', is_reviewed_by_buyer='0'");
			$db->query();
			//update offer approved
			$db->setQuery("UPDATE #__barter_listing SET offer_approved = offer_approved + 1  WHERE id = $item_id");
			$db->query();
			$offer = "SELECT * FROM #__barter_listing ORDER BY id DESC limit 0,1";
			$db->setQuery($offer);
			$offer_detail = $db->loadAssoc(); 
			$offer_id = $offer_detail['id'];
			header("Location: index.php?option=com_listing&view=browse&layout=offerview&offer_id=$offer_id");
		}
}//end if they can afford it

