<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
?>
<?php
		$user =& JFactory::getUser();
	  $user_id=$user->get('id');
    $sendername=$user->get('username');
	  $db	=& JFactory::getDBO();
	  //get account info
	  $account = "SELECT * FROM #__barter_account limit 0,1";
	  $db->setQuery($account);
	  $account_detail = $db->loadAssoc(); 
	 // print_r($account_detail);die;
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
	  if($receiver_id == '')
	  {
	  echo "Sorry! We have not found this username.";
	  }
	  else
	  {
	  require_once('components/com_listing/paypal.php');
	  require_once('components/com_listing/httprequest.php');
	  $r = new PayPal(TRUE);
	  $varurl = JURI::base();
	  $return_url = "$varurl"."index.php?option=com_listing&task=success";
	  $r->setReturnUrl($return_url);
	  //set username
	  $transaction_comment = $account_detail['payment_title'];
	  $ret = ($r->doExpressCheckout($commission, "$transaction_comment",rand(10,1000),'USD'));
	  }
	  }
	  else
	  {
	  echo "Sorry! you have no available credits.";
	  }
	  }
	  else
	  {
	  ?>
	  <p>
	  There's more than one way to skin a cat, and theres more than one way to buy and sell. As well as just using hard cash or bartering, you can use your credits to pay for items or services you want to acquire from other members of the community. Just agree on how much you have to pay, and use our simple transfer credits feature to move credits from your account to somebody elses.
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
	  ?>
	  </div>
	  <div class="clear"></div>
	  </div>