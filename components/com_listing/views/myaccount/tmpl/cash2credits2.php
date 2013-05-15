<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
  $user =& JFactory::getUser();
	$user_id=$user->get('id');
	$user_email=$user->get('email');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
	$username=$user->get('username');
	$comments=$user->get('comments');
	//print_r($comments);die;
	$db	=& JFactory::getDBO();
	//get account info
	$account = "SELECT * FROM #__barter_account limit 0,1";
	$db->setQuery($account);
	$account_detail = $db->loadAssoc(); 
	?>
    <?php echo ListingHelper::topMenu(); ?>
	<div class="listing">
	<div class="right">
	<?php
	if($_REQUEST['submit'] == 'Submit')
	{
	$amount =$_REQUEST['amount'];
	$my_dup_row = array( 'amount' => $amount, 'username' => $username, 
	'comments' => $comments );
	$session =& JFactory::getSession();
	$session->set('my_dup_row', $my_dup_row);
	$receiver_id  = $user->get('id');
	
	require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.class.php');

	$p = new paypal_class;
	
	$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';  
	
	   $this_script 		= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount&layout=cash2creditsSuccess';

	 $this_script_cancal = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount';

			$amt = JRequest::getVar('amount');

		if (!empty($amt)) { $act = 'process'; } 
		
  //$ar = explode("$",$array_maile[1]);		 

	 switch ($act) 
		{

		   case 'process':      // Process and order...
				$p->add_field('business', $account_detail['paypal_api_username']);
				$p->add_field('item_title', $account_detail['payment_title']); 
			  $p->add_field('return', $this_script.'&action=success');
			  $p->add_field('cancel_return', $this_script_cancal.'&action=cancel');
			  $p->add_field('notify_url', $this_script.'&action=ipn');
			  $p->add_field('currency_code','USD');
			  $p->add_field('amount',$amt);
				//  $p->add_field('item_number',$lastid);
			//  $p->add_field('tax', $total_tax);
			  $p->submit_paypal_post(); // submit the fields to paypal
			  //$p->dump_fields();      // for debugging, output a table of all the fields
			  break;

		   case 'success':      // Order was successful..

				die(header('Location: index.php?option=com_listing&view=browse&layout=cash2creditsSuccess'));
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

	
	//$ret = ($r->doExpressCheckout($amount, "Cash to Trade Credits",rand(10,1000),'USD'));
	
	//$varurl = JURI::base();
//	//$url = "$varurl"."index.php?option=com_listing&view=myaccount&layout=cash2creditsSuccess";
	//$r->setReturnUrl($url);
	
	
	//$final = $r->doPayment($amount,$receiver_id);
	//print_r($final);
	//$final = $r->doPayment($amount,$receiver_id);
    //print_r($final);
    //if($final['ACK']=='Success') {
	//echo 'Succeed!';
    // } else {
    //print_r($final);
    // }
    //die();
	//$ret = ($r->doExpressCheckout(10, 'Access to source code library'));
	//print_r($ret);die;
	}
	else
	{
	echo "sorry u dont have credit balance!";
	}
	?>
	</div>
	</div>