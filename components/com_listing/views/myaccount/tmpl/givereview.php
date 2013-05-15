<?php
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
$user =& JFactory::getUser();



	$user_id=$user->get('id');



	$offer_id = JRequest::getInt('offer_id');



	$db	=& JFactory::getDBO();



	$db->setQuery("SELECT lo.id as id,



                          lo.listing_id as listing_id,



                          lo.offered_by as offered_by,



						  lo.offered_to as offered_to,



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



						  u.name as buyer_name,



						  (SELECT s.name FROM #__users s WHERE s.id = lo.offered_to) as seller_name



	               FROM #__barter_listing_offer lo



				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id



				   INNER JOIN #__users u ON u.id = lo.offered_by



				   WHERE lo.id = $offer_id");



	$rows = $db->loadAssoc();







	



	if($_REQUEST['submit'] == 'Submit')



	{



		if($user_id == $rows['buyer_id'])



		{



			//insert review



			$db->setQuery("INSERT INTO #__barter_user_reviews SET id = '', listing_id='" . $rows['listing_id'] . "', reviewer_sender_id='" . $rows['buyer_id'] . "', reviewer_receiver_id='" . $rows['offered_to'] . "', review='" . $_REQUEST['review'] . "', score='" . $_REQUEST['score'] . "', created_date='" . date('Y-m-d H:m:s') . "'");



			$db->query();



			



			//update is_reviewed_by_buyer



			$db->setQuery("UPDATE #__barter_listing_offer SET is_reviewed_by_buyer = 1  WHERE id = $offer_id");



			$db->query();



			



			//update total review



			$user = $rows['offered_to'];



			$db->setQuery("UPDATE #__barter_users_history SET total_reviews = total_reviews + 1  WHERE user_id = $user");



			$db->query();



			



			if($_REQUEST['score'] == 1)



			{



				$db->setQuery("UPDATE #__barter_users_history SET total_positive_reviews = total_positive_reviews + 1  WHERE user_id = $user");



				$db->query();



			}



			elseif($_REQUEST['score'] == 0)



			{



				$db->setQuery("UPDATE #__barter_users_history SET total_negative_reviews = total_negative_reviews + 1  WHERE user_id = $user");



				$db->query();



			}



		}



		else



		{



			//insert review

			

			$score = JRequest::getInt('score');

			

			$review = JRequest::getString('review');



			$db->setQuery("INSERT INTO #__barter_user_reviews SET id = '', listing_id='" . $rows['listing_id'] . "', reviewer_sender_id='" . $rows['offered_to'] . "', reviewer_receiver_id='" . $rows['buyer_id'] . "', review='" . $review . "', score='" . $score . "', created_date='" . date('Y-m-d H:m:s') . "'");



			$db->query();



			//update is_reviewed_by_buyer



			$db->setQuery("UPDATE #__barter_listing_offer SET is_reviewed_by_seller = 1  WHERE id = $offer_id");



			$db->query();



			//update total review



			$user = $rows['buyer_id'];



			$db->setQuery("UPDATE #__barter_users_history SET total_reviews = total_reviews + 1  WHERE user_id = $user");



			$db->query();



			if($_REQUEST['score'] == 1)



			{



				$db->setQuery("UPDATE #__barter_users_history SET total_positive_reviews = total_positive_reviews + 1  WHERE user_id = $user");



				$db->query();



			}



			elseif($_REQUEST['score'] == 0)



			{



				$db->setQuery("UPDATE #__barter_users_history SET total_negative_reviews = total_negative_reviews + 1  WHERE user_id = $user");



				$db->query();



			}



		}



		header("Location: index.php?option=com_listing&view=myaccount&layout=offerview&offer_id=$offer_id");



	}



	else



	{



		?>



		<div class="listing">







			<div class="right">



				<form action="index.php?option=com_listing&view=myaccount&layout=givereview&offer_id=<?php echo $offer_id; ?>" method="post" name="adminForm" enctype="multipart/form-data">



					<fieldset class="adminform">



						<table class="admintable">



							<tbody>



								<tr>



									<td>



										<input type="radio" name="score" checked="checked" value="1" />Positive



									</td>



								</tr>



								<tr>



									<td>



										<input type="radio" name="score" value="0" />Negative



									</td>



								</tr>



								



								<tr>



									<td class="key">



										<strong>Review</strong>



									</td>



								</tr>



								<tr>	



									<td>



										<textarea id="review" name="review" cols="30" rows="5"></textarea>



									</td>



								</tr>



								



								<tr>



									<td>



										<input type="submit" name="submit" value="Submit">



										<input type="hidden" name="s_offer_id" value="<?php echo $offer_id; ?>">



									</td>



								</tr>



							</tbody>



						</table>



					</fieldset>



				</form>



			</div>



			<div class="clear"></div>



		</div>



		<?php



	}