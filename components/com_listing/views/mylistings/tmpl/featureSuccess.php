<?php //user comes here after paying for one month of listing being featured.
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$listing_id = JRequest::getInt('listing_id');

//$session =& JFactory::getSession();
//$my_dup_row = $session->get('my_dup_row');
//$listing_id = $my_dup_row['listing_id'];
//echo $listing_id; //die;	

echo ListingHelper::topMenu();
//checkLoggedInUser();
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	$username=$user->get('username');
	$db	=& JFactory::getDBO();
	?>
	<div class="listing">
		<div class="right">
<?php
//get token and payerid
$token   = $_REQUEST['token'];
$payerid = $_REQUEST['PayerID'];
$payerID = urlencode("$payerid");
$token   = urlencode("$token");
			
require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.class.php');
$r = new paypal_class;
//$final = $r->doPayment($token,$payerID);
$final =	$account_detail;
//if ($final['ACK'] == 'Success')
if ($final)
	{
		$session =& JFactory::getSession();
		$my_dup_row = $session->get('my_dup_row');
		$db	=& JFactory::getDBO();
		//record to database
		$now = time();
		$end_date = $now + 2592000;
		$db->setQuery("INSERT INTO #__barter_listing_featured SET id = '', listing_id='" . $listing_id . "', start_date='" . $now . "', end_date='" . $end_date . "'");
		$db->query();
		echo "Thank you for featuring your listing.";
	}
	?></div></div>
