<?php
defined('_JEXEC') or die('Restricted Error');
$app =& JFactory::getApplication();
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
$user =& JFactory::getUser();
$user_id=$user->get('id');
$offer_id = JRequest::getInt('offer_id');		
$db	=& JFactory::getDBO();
$db->setQuery("SELECT lo.id as id,
                          lo.listing_id as listing_id,
                          lo.offered_by as offered_by,
                          lo.desired_quantity as desired_quantity,
                          lo.amount_of_trade_credits as amount_of_trade_credits,
                          lo.amount_of_cash as amount_of_cash,
                          lo.comments as comments,
                          lo.created_date as created_date,
                          lo.status as status,
                          lo.is_reviewed_by_seller as is_reviewed_by_seller,
                          lo.is_reviewed_by_buyer as is_reviewed_by_buyer,
						  l.listing_title as listing_title,
						  u.id as buyer_id,
						  u.name as buyer_name
	               FROM #__barter_listing_offer lo
				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id
				   INNER JOIN #__users u ON u.id = lo.offered_by
				   WHERE lo.id = $offer_id");
	$rows = $db->loadAssoc();
	if($rows['status'] == 'pending')
	{
		//update offer status
		$db->setQuery("UPDATE #__barter_listing_offer SET status = 'rejected' WHERE id = $offer_id");
		$db->query();

		//notify the one who sent the offer (buyer) - send email					 		
		$mailer =& JFactory::getMailer();
		$config =& JFactory::getConfig();
    $sender = array( 
        $config->getValue( 'config.mailfrom' ),
        $config->getValue( 'config.fromname' ) );
		$sitename =& $config->getValue( 'config.sitename' );
		$livesite =& $config->getValue( 'config.live_site' );
		$offered_by = $rows['offered_by'];
		$listing_title = $rows['listing_title'];
		$item_id = $rows['listing_id'];
		$desired_quantity = $rows['desired_quantity'];
		$amount_of_cash = $rows['amount_of_cash'];
		$amount_of_trade_credits = $rows['amount_of_cash'];
		$comments = $rows['comments'];
		$user =& JFactory::getUser($offered_by);//for the buyer info
    $recipient = $user->email;
		$seller_name = $user->username;
    $mailer->addRecipient($recipient);
		$mailer->setSubject(''.$seller_name.' has rejected an offer.');
		$emailBody = "<table border='0'>
									<tr>
										<td>Seller Name: $seller_name</td>
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
										<td><BR />GOTO > myaccount > offers<a href=\"".$livesite."\">".$sitename."</a></td></tr></table>";
    $mailer->isHTML(true);
    $mailer->Encoding = 'base64';
    $mailer->setBody($emailBody);
		$mailer->setSender($sender);//Global Configuration -> Server -> Mail Settings
		$send =& $mailer->Send();
    if ( $send !== true ) {
        //echo 'Error sending email: ' . $send->message;
    } else {
        //echo 'Mail sent';
				header("Location: index.php?option=com_listing&view=myaccount&layout=offerview&offer_id=$offer_id");
		}
}
