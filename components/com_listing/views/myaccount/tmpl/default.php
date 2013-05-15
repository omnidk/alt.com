<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");

echo ListingHelper::topMenu();
?>
<style type="text/css">
table {
	border:none;
}
tr, td {
	border:none;
	border-width:0px;
}
</style>
<?php
 $user =& JFactory::getUser();
 $user_id=$user->get('id');
	if($user_id == 0)
	{
	$msg = JText::_( "Please login....");
			$redirectUrl = base64_encode("index.php?option=com_listing&view=myaccount");
			$version = new JVersion;
            $joomla = $version->getShortVersion();
            if(substr($joomla,0,3) == '1.5'){
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);
            }else{
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);
            }
			JFactory::getApplication()->redirect($link, $msg);
	 }
	?>
<?php
$user =& JFactory::getUser();
$user_id=$user->get('id');
$database 	= & JFactory::getDBO();
     //get user info
$database->setQuery("SELECT u.id as user_id,
						u.name as full_name,
						u.email as email,
						uh.total_balance as total_balance,
						uh.line_of_credit as line_of_credit,
						uh.total_reviews as total_reviews
				        FROM #__users u
				        LEFT JOIN #__barter_users_history uh ON uh.user_id = u.id
						 WHERE u.id = $user_id
						");
$database->query();
$userinfo = $database->loadAssoc();
//get total new message
$database->setQuery("SELECT count(id) as total
					 FROM #__barter_user_messages
					 WHERE receiver_id = $user_id AND is_read = 0
					");
	$database->query();
$totalmessage = $database->loadAssoc();
//get total new offer
$database->setQuery("SELECT count(id) as total
						 FROM #__barter_listing_offer
						 WHERE offered_to = $user_id AND status = 'pending'
						");
$database->query();
$totaloffer = $database->loadAssoc();
?>
<?php //echo ListingHelper::userMenu(); // code coments by nipu?>
<form method="post" action="index.php"  name="adminForm" >
  <table cellspacing="5" cellpadding="5" border="1">
    <tbody>
      <tr>
        <td width="20%" class="key"><h5> Welcome</h5></td>
        <td><?php echo $userinfo['full_name'];?></td>
      </tr>
      <tr>
        <td width="20%" class="key"><h5> New Messages:</h5></td>
        <td><?php echo $totalmessage['total'] ; ?></td>
      </tr>
      <tr>
        <td width="20%" class="key"><h5> New Offers:</h5></td>
        <td><?php echo $totaloffer['total']; ?></td>
      </tr>
      <tr>
        <td width="20%" class="key"><h5> Your Balance:</h5></td>
        <td><?php echo'$'. $userinfo['total_balance']; ?></td>
      </tr>
      <tr>
        <td width="20%" class="key"><h5> Line of Credit:</h5></td>
        <td><?php echo '$'. $userinfo['line_of_credit']; ?></td>
      </tr>
      <tr>
        <td colspan="2" ><ul class="account_menu">
            <li><a href="index.php?option=com_listing&view=myaccount&layout=inbox">Inbox</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=sentmessage">Sent Message</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=receivedoffer">Received Offers</a></li>
						<li><a href="index.php?option=com_listing&view=myaccount&layout=sentoffer">Sent Offers</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=archivedoffer">Archived Offers</a></li>
						<li><a href="index.php?option=com_listing&view=myaccount&layout=watching">Watch List</a></li>
						<li><a href="index.php?option=com_listing&view=myaccount&layout=biddingon">Bidding On</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=salescredits">Sales History</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=purchasecredits">Purchase History</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=receivedcredits">Received Credits</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=sentcredits">Sent Credits</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=transfer">Transfer Credits</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=cash2credits">Cash to Credits</a></li>
            <li><a href="index.php?option=com_listing&view=myaccount&layout=invoices">Invoices</a></li>
          </ul>
          <?php //echo ListingHelper::userMenu(); ?></td>
      </tr>
      
      <!--</tr>
  <div><a href="index.php?option=com_listing&view=myaccount&layout=inbox">Inbox</a></div>
 <div><a href="index.php?option=com_listing&view=myaccount&layout=sentmessage">Sent Message</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=receivedoffer">Received Offer</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=archivedoffer">Achived Offer</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=salescredits">Sales History</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=purchasecredits">Purchased History</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=receivedcredits">Received Credits</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=sentcredits">Sent Credits</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=transfer">Transfer Credits</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=cash2credits">Cash to Credits</a></div>
<div><a href="index.php?option=com_listing&view=myaccount&layout=invoices">Invoices</a></div>

  </tr>-->
    </tbody>
  </table>
  <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="myaccount" />
  <input type="hidden" name="task" value=""/>
</form>
