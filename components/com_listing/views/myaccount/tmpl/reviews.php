<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");


echo ListingHelper::topMenu();?>
<?php
 $user =& JFactory::getUser();
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
	$user_id = JRequest::getInt('user_id');
	$db	=& JFactory::getDBO();
	//get user info
	$db->setQuery("SELECT username
						 FROM #__users
						 WHERE id = $user_id
						");
	$db->query();
	$userinfo = $db->loadAssoc();
	//get user review info
	$db->setQuery("SELECT *
						 FROM #__barter_users_history
						 WHERE user_id = $user_id
						");
	$db->query();
	$userreview = $db->loadAssoc();
	if($userreview['total_reviews'] == 0){
	$review_parcent = "100";
	}else{
	$review_parcent = ($userreview['total_positive_reviews'] * 100)/$userreview['total_reviews'];
	}
	//get all reviews
    $query = "SELECT * FROM #__barter_user_reviews";
	$db->setQuery($query);
	$rows = $db->loadObjectlist();
	/*$db->setQuery("SELECT ur.id as id,
                          ur.listing_id as listing_id,
                          ur.reviewer_sender_id as reviewer_sender_id,
						  ur.review as review,
                          ur.created_date as created_date,
                          ur.score as score,
						  l.listing_title as listing_title,
						  u.name as full_name
	               FROM #__barter_user_reviews ur
				   INNER JOIN #__barter_listing l ON l.id = ur.listing_id
				   INNER JOIN #__users u ON u.id = ur.reviewer_sender_id
				   WHERE ur.reviewer_receiver_id = $user_id");*/
	//topMenu();
	?>
	<div class="listing">
		<h3>Username:<?php  echo $userinfo['username']; ?></h3>	
		<table border="0" width="50%">
			<tr>
				<td><strong>Positive:</strong> &nbsp;<?php echo $userreview['total_positive_reviews']; ?></td>
			</tr>
			<tr>
				<td><strong>Negative:</strong> &nbsp;<?php echo $userreview['total_negative_reviews']; ?></td>
			</tr>
			<tr>
				<td><strong>Overall Percentage:</strong> &nbsp;<?php echo $review_parcent; ?>%</td>
			</tr>
		</table>
		<br />
		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
					<th scope="col">From</th>
					<th scope="col">Item Title</th>
					<th scope="col">Item ID#</th>
					<th scope="col">Review</th>
				</tr>
			</thead>
			<tbody id="items">
				<?php $i=1;
					foreach($rows as $row)
					{
						?>
						<tr id='post-102' class='alternate'>
							<td class="centeralign">
                            <?php echo $user_name = ListingHelper::detail('#__users','','username','id',$row->reviewer_sender_id,'','loadresult'); ?>
                            </td>
							<td class="centeralign"><?php echo $row->listing_title; ?></td>
							<td class="centeralign"><?php echo $row->listing_id; ?></td>
							<td class="centeralign"><?php echo $row->review; ?></td>
						</tr>
						<?php
						$i++;
					}
			?>	
			</tbody>
		</table>
	</div>


