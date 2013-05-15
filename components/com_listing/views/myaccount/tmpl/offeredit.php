<?php
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();

$offer_id = JRequest::getInt('offer_id');
//print_r($offer_id);die;
//echo "sdsds";die;


	$db	=& JFactory::getDBO();



	//if($_REQUEST['submit'] == 'Edit Offer')

if($offer_id);

	{
		//edit
		$desired_quantity = JRequest::getInt('desired_quantity');

//print_r($desired_quantity);die;
		$amout_of_trade_credits = JRequest::getFloat('amount_of_trade_credits');
		

		$amount_of_cash = JRequest::getFloat('amount_of_cash');


		$comments = JRequest::getString('comments');		


		$db->setQuery("UPDATE #__barter_listing_offer SET desired_quantity = $desired_quantity,amount_of_trade_credits = $amount_of_trade_credits,amount_of_cash = $amount_of_cash,comments = '$comments' WHERE id = $offer_id");


		$db->query();



		header("Location: index.php?option=com_listing&view=myaccount&layout=offerview&offer_id=$offer_id");



	}



	



	$db->setQuery("SELECT lo.id as id,



                          lo.listing_id as listing_id,



                          lo.offered_by as offered_by,



						  lo.offered_to as offered_to,



                          lo.desired_quantity as desired_quantity,



                          lo.amount_of_trade_credits as amount_of_trade_credits,



                          lo.amount_of_cash as amount_of_cash,



                          lo.comments as comments,



						  l.listing_title as listing_title



	               FROM #__barter_listing_offer lo



				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id



				   WHERE lo.id = $offer_id");



	$rows = $db->loadAssoc();



	//topMenu();



	?>



	<div class="listing">



		<div>You are editing an offer on <?php echo $rows['desired_quantity']; ?> of Item Number <?php echo $rows['listing_id']; ?>, <b><?php echo $rows['listing_title']; ?></b></div>



		<?php /*?><form action="index.php?option=com_listing&viewmyaccount&layout=editoffer&offer_id=<?php echo $offer_id; ?>" method="post" name="adminForm" enctype="multipart/form-data"><?php */?>
         <form action="index.php?option=com_listing&viewmyaccount&layout=offeredit&offer_id=<?php echo $offer_id; ?>" method="post" name="adminForm" enctype="multipart/form-data">



			<fieldset class="adminform">



				<table class="admintable">



					<tbody>



						<tr>



							<td class="key">



								<label for="message">Amount of Trade Credits to include</label>



							</td>



						</tr>	



						<tr>



							<td>



								<input class="inputbox" type="text" name="amount_of_trade_credits" id="amount_of_trade_credits" size="40" value="<?php echo $rows['amount_of_trade_credits']; ?>" />



							</td>



						</tr>



						<tr>



							<td class="key">



								<label for="message">Amount of Cash to include</label>



							</td>



						</tr>	



						<tr>



							<td>



								<input class="inputbox" type="text" name="amount_of_cash" id="amount_of_cash" size="40" value="<?php echo $rows['amount_of_cash']; ?>" />



							</td>



						</tr>



						<tr>



							<td class="key">



								<label for="message">Type comments to the Seller in this box</label>



							</td>



						</tr>



						<tr>



							<td>



								<textarea id="comments" name="comments" cols="30" rows="5"><?php echo $rows['comments']; ?></textarea>



							</td>



						</tr>



						<tr>



							<td>



								<input type="submit" name="submit" value="Edit Offer">



								<input type="hidden" name="desired_quantity" value="<?php echo $rows['desired_quantity']; ?>">



							</td>



						</tr>



					</tbody>



				</table>



			</fieldset>



		</form>



	</div>

