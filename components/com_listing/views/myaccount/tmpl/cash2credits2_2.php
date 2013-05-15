<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
 
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
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
    <?php echo ListingHelper::usermenu(); ?>
	<div class="listing">
	<div class="right">
	<?php
	if($_REQUEST['submit'] == 'Submit')
	{
	$amount   = $_REQUEST['amount'];
	$my_dup_row = array( 'amount' => $amount, 'username' => $username, 
	'comments' => $comments );
	$session =& JFactory::getSession();
	$session->set('my_dup_row', $my_dup_row);
	$receiver_id  = $user->get('id');
	require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.php');
	require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'httprequest.php');
	
	$r = new PayPal(TRUE);
	$final = $r->doPayment($amount,$receiver_id);
	//print_r($receiver_id);die;
	$varurl = JURI::base();
	$return_url = "$varurl"."index.php?option=com_listing&view=myaccount&layout=cash2creditsSuccess";
	$r->setReturnUrl($return_url);
	$ret = ($r->doExpressCheckout($amount, "Cash to Trade Credits",rand(10,1000),'USD'));
	
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
	echo "sorry u dont have credit balance!"
	?>
	<?php /*?><p>Now you can buy trade credits with cash!  Exchange rate is 1:1</p>
	<form action="index.php?option=com_listing&task=cash2credits" method="post" name="adminForm" enctype="multipart/form-data">
	<fieldset class="adminform">
	<table class="admintable">
	<tbody>
	<tr>
	<td width="40%" class="key">
	<label for="message">Trade credits desired</label>
	</td>
	<td>
	<input class="inputbox" type="text" name="amount" id="amount" size="40" value="" />
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
	</form>	<?php */?>
	<?php
	}
	?>
	</div>
	</div>