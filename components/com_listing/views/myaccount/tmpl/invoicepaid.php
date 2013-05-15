<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
 if($_REQUEST['submit'] == 'Pay'){
						//get account info
						$db = & JFactory::getDBO();
          	$account = "SELECT * FROM #__barter_account limit 0,1";
          	$db->setQuery($account);
          	$account_detail = $db->loadAssoc(); 
						$invoiceID = JRequest::getInt('invoiceID');
						$amt = JRequest::getInt('amt');						
						//create session var for marking db after commission is paid
						$my_dup_row = array( 'amt' => $amt, 'invoiceID' => $invoiceID );
						$session =& JFactory::getSession();
						$session->set('my_dup_row', $my_dup_row);
						require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'paypal.php');
						require_once(JPATH_SITE.DS.'components'.DS.'com_listing'.DS.'httprequest.php');
						//require_once('components/com_listing/paypal.php');
						//require_once('components/com_listing/httprequest.php');
						$r = new PayPal(TRUE);
						$varurl = JURI::base();
						$return_url = "$varurl"."index.php?option=com_listing&task=invoicepaid";
						$r->setReturnUrl($return_url);						
						$transaction_comment = $account_detail['payment_title'];
						$ret = ($r->doExpressCheckout($amt,"$transaction_comment",rand(10,1000),'USD'));
                        echo "error: problem connecting to paypal.";

		}