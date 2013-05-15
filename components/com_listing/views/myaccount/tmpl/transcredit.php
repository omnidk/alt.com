<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
?>
<?php
 $user =& JFactory::getUser();
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	$user_email=$user->get('email');
	
	  $sendername=$user->get('username');
	  $db	=& JFactory::getDBO();
	  //get account info
	  $account = "SELECT * FROM #__barter_account limit 0,1";
	  $db->setQuery($account);
	  $account_detail = $db->loadAssoc(); 
	  //print_r($account_detail);die;
	  ?>
	  <div class="listing">
	  <div class="right">
	  <?php
	  if($_REQUEST['submit'] == 'Submit')
	  {
	  $amount = JRequest::getFloat('amount');
	  $username = JRequest::getString('username');
	  $comments = JRequest::getString('comments');
	  $commission = ($amount*$account_detail['comission_percent'])/100;
	  $my_dup_row = array( 'amount' => $amount, 'username' => $username, 
	  'comments' => $comments );
	  $session =& JFactory::getSession();
	  $session->set('my_dup_row', $my_dup_row);				
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
	  
	  $db->setQuery("SELECT `comission_percent` from #__barter_account");
	  $db->query();
	  $commission = $db->loadResult();
	  
	  $amtCommission = ($amount / 100) * $commission;
	  
	   //$amount_tax= $amount+ $tax_estimate ;
	 		
	  if($total_balance_and_line_credit > $amount)
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
	 // print_r( $receiver_id);die;
	  if($receiver_id == '')
	  {
	  echo "Sorry! We have not found this username.";
	  }
	  else
	  {
	require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.class.php');
	  $p = new paypal_class;
	  
	  $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	  
	    $this_script 		= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount&layout=success';

	 $this_script_cancal = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount';
	//  $varurl = JURI::base();
	//  $return_url = "$varurl"."index.php?option=com_listing&view=myaccount&layout=success";
	//  $r->setReturnUrl($return_url);
	  //set username
	  $description=JRequest::getVar('comments');
		$act = JRequest::getVar('amount');
		       
		if (!empty($act)) {$act = 'process';}	

//$ar = explode("$",$array_maile[1]);		 

		 switch ($act) 

		{

		   case 'process':      // Process and order...
			 
				$p->add_field('business', $account_detail['paypal_api_username']);
				$p->add_field('item_title', $account_detail['payment_title']);        
			  $p->add_field('return', $this_script.'&action=success');				
			  $p->add_field('cancel_return', $this_script_cancal.'&action=cancel');
			  $p->add_field('notify_url', $this_script.'&action=ipn');			  
        $p->add_field('description','trade credits purchase');			   
			  $p->add_field('Features', 'size,color');			  
			  $p->add_field('currency_code','USD');			  
			  $p->add_field('amount',$amtCommission);			
			//  $p->add_field('item_number',$lastid);			  
			//  $p->add_field('tax', $total_tax);
			  $p->submit_paypal_post(); // submit the fields to paypal
			  //$p->dump_fields();      // for debugging, output a table of all the fields

			  break;

		   case 'success':      // Order was successful..

			  echo "<html><head><title>"._MSG_SUCCESS."</title></head><body><h3>"._MSG_THANKYOU."</h3>";

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

							//  case "payer_email":
							////	$body .= " Payer Email: ".$email."\r\n";
							//	break;
						}
					}
			  }
			  break;
}
	  }
	  }
	  else
	  {
	  echo "Sorry! you have no available credits.";
	  }
	  }
	  /*?> else
	  {
	  ?>
	  <p>
	  There's more than one way to skin a cat, and theres more than one way to buy and sell. As well as just using hard cash or bartering, you can use your credits to pay for items or services you want to acquire from other members of the community. Just agree on how much you have to pay, and use our simple transfer credits feature to move credits from your account to somebody else.
	  </p>
	  <form action="index.php?option=com_listing&view=myaccount&layout=transfer" method="post" name="adminForm" enctype="multipart/form-data">
	  <fieldset class="adminform">
	  <table class="admintable">
	  <tbody>
	  <tr>
	  <td width="40%" class="key">
	  <label for="message">Transfer Amount</label>
	  </td>
	  <td>
	  <input class="inputbox" type="text" name="amount" id="amount" size="40" value="" />
	  </td>
	  </tr>
	  <tr>
	  <td width="40%" class="key">
	  <label for="message">Destination Account or Username</label>
	  </td>
	  <td>
	  <input class="inputbox" type="text" name="username" id="username" size="40" value="" />
	  </td>
	  </tr>
	  <tr>
	  <td width="40%" class="key">
	  <label for="message">Comment</label>
	  </td>
	  <td>
	  <input class="inputbox" type="text" name="comment" id="comment" size="40" value="" />
	  </td>
	  </tr>
	  <tr>
	  <td width="20%" class="key">
	  <label for="published">&nbsp;</label>
	  </td>
	  <td>
	  <input type="submit" name="submit" value="Submit">
	  </td>
	  </tr>
	  </tbody>
	  </table>
	  </fieldset>
	  </form>	
	  <?php
	  }
	  ?><?php */?>
	  </div>
	  <div class="clear"></div>
	  </div>