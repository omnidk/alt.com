<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$db	=& JFactory::getDBO();	
$user =& JFactory::getUser();
$user_id=$user->get('id');
$listing_id=JRequest::getInt('listing_id');
$payment=JRequest::getWord('payment');
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
ListingHelper::checkLoggedInUser();
echo ListingHelper::topMenu();

if($payment == "month"){
//echo "month";//run paypal transaction

	$my_dup_row = array( 'amount' => $amount, 'username' => $username, 
	'comments' => $comments );
	$session =& JFactory::getSession();
	$session->set('my_dup_row', $my_dup_row);

//get parameters for paypal transaction
jimport('joomla.application.component.helper');
$payto = JComponentHelper::getParams('com_listing')->get('payto');
$amt = JComponentHelper::getParams('com_listing')->get('tofeature');
$trans_title = "Feature Listing";

	require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.class.php');
	$p = new paypal_class;	
	$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; 
	$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount&layout=feature';
	$this_script_cancal = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?option=com_listing&view=myaccount';

	if (!empty($amt)) { $act = 'process'; } 		
  //$ar = explode("$",$array_maile[1]);		 
	 switch ($act) 
		{
		   case 'process':      // Process and order...
				$p->add_field('business', $payto);
				$p->add_field('item_title', $trans_title); 
			  $p->add_field('return', $this_script.'&action=success');
			  $p->add_field('cancel_return', $this_script_cancal.'&action=cancel');
			  $p->add_field('notify_url', $this_script.'&action=ipn');
			  $p->add_field('currency_code','USD');
			  $p->add_field('amount',$amt);
				//$p->add_field('item_number',$lastid);
			  //$p->add_field('tax', $total_tax);
			  $p->submit_paypal_post(); // submit the fields to paypal
			  //$p->dump_fields();      // for debugging, output a table of all the fields
			  break;
		   case 'success':      // Order was successful..
			 
			 	//for security, set session variables
			 	$my_dup_row = array( 'listing_id' => $listing_id );
				$session =& JFactory::getSession();
				$session->set('my_dup_row', $my_dup_row);
				
				die(header('Location: index.php?option=com_listing&view=mylistings&layout=featureSuccess&listing_id='.$listing_id.'&payment=month'));
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
				//we'll email  ALL the data.
				$subject = 'Instant Payment Notification - Recieved Payment';
				//$to = $email;   ;//  your email
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
	
	 
}
if($payment == "subscribe"){
echo "subscribe";//process for a subscription - to be a featured listing
}

//-----pre-payment screen ------------------------------------------
$db->setQuery("SELECT listing_title FROM #__barter_listing WHERE `id` = '$listing_id'");
$listing_title = $db->loadResult(); 

	?>
	<div class="listing">
	<p>Feature your listing, <a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $listing_id; ?>"><?php echo $listing_title ?></a><br />it will show above the rest in search results and browse pages.</p>
	<p>You can make a <a href="index.php?option=com_listing&view=mylistings&layout=feature&payment=month&id=<?php echo $listing_id; ?>">one time payment</a> for a month of being featured,</p>
	<p>or you can <a href="index.php?option=com_listing&view=mylistings&layout=feature&payment=subscribe&id=<?php echo $listing_id; ?>">subscribe</a> so that your listings stays on top.</p>
	</div>