<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
//checkLoggedInUser();
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	$username=$user->get('username');
	$db	=& JFactory::getDBO();
	//get account info
	$account = "SELECT * FROM #__barter_account limit 0,1";
	$db->setQuery($account);
	$account_detail = $db->loadAssoc(); 
	?>
	<div class="listing">
<?php /*?><?php userMenu(); ?><?php */?>
		<div class="right">
<?php
	//get token and payerid
//$token   = $_REQUEST['token'];

//$payerid = $_REQUEST['PayerID'];

	//$payerID = urlencode("$payerid");

	//$token   = urlencode("$token");

			
  require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.class.php');
	//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.php');

	//require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'httprequest.php');



	$r = new paypal_class;



	//$final = $r->doPayment($token,$payerID);

$final =	$account_detail;

	//if ($final['ACK'] == 'Success')
  	if ($final)
	{

		$session =& JFactory::getSession();

		$my_dup_row = $session->get('my_dup_row');

		$db	=& JFactory::getDBO();

		$amount = $my_dup_row['amount'];	
		//record to database

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

		$balance = $userinfo['total_balance'];

		$newBalance = $balance + $amount;
       
		$newBalance = floatval($newBalance);
		 //print_r($newBalance);die;
		//print_r($amount);die;
     // $r="INSERT INTO #__barter_users_history      (`user_id`,`broker_id`,`total_balance`,`line_of_credit`,`total_reviews`,`total_positive_reviews`,`total_negative_reviews`)values('".$user_id."','0','".$amount."','0','0','0','0')";
	// echo $r;die;
	
   // $db->setQuery("INSERT INTO #__barter_users_history  (`user_id`,`broker_id`,`total_balance`,`line_of_credit`,`total_reviews`,`total_positive_reviews`,`total_negative_reviews`)values('".$user_id."','0','".$amount."','0','0','0','0')");
	 /// $db->query();
	 // $u = $db->loadAssoc();
 //print_r($u);die;
		//insert new balance

		$db->setQuery("UPDATE #__barter_users_history SET total_balance = $newBalance WHERE user_id = $user_id");
		$db->query();

		echo "Thank you for purchasing ".$amount." trade credits.";
	}
