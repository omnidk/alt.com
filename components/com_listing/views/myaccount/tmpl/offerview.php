<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper:: topMenu();
ListingHelper::checkLoggedInUser();
$user =& JFactory::getUser();
$user_id=$user->get('id');
$offer_id = JRequest::getVar('offer_id');
$db	=& JFactory::getDBO();
//$query = "SELECT * FROM #__barter_listing_offer";
//$db->setQuery($query);
//$rows = $db->loadAssoc();
$db->setQuery("SELECT lo.id as id,
	                        lo.type as type,
													lo.parent as parent,
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
						  lo.is_archived_by_seller as is_archived_by_seller,
                          lo.is_archived_by_buyer as is_archived_by_buyer,
						  l.listing_title as listing_title,
						  u.id as buyer_id,
						  u.name as buyer_name,
						  (SELECT s.name FROM #__users s WHERE s.id = lo.offered_to) as seller_name
	               FROM #__barter_listing_offer lo
				   INNER JOIN #__barter_listing l ON l.id = lo.listing_id
				   INNER JOIN #__users u ON u.id = lo.offered_by
				   WHERE lo.id = $offer_id");
	$rows = $db->loadAssoc();
	//topMenu();
	?>
		<div class="listing">
<?php //userMenu(); ?>
			<div class="right">
				<?php /*?><?php
				if($rows['status'] == 'pending')
				{
					echo '<h2 style="color:red;text-align:center;border:1px solid red;padding:5px;margin-bottom:10px">Pending</h2>';
				}
				?><?php */?>
				<?php /*?><h3><a href="index.php?option=com_listing&task=items&item_id=<?php echo $rows['listing_id']; ?>"><?php echo $rows['listing_title']; ?></a></h3>	<?php */?>
				<table border="0" width="70%">
				<h2>
				<?php
				$type = $rows['type'];
				$parent = $rows['parent'];
				if($type == '2'){
				echo "Counter-Offer RE; <a href=\"index.php/component/listing/?view=myaccount&layout=offerview&offer_id=".$parent."\">offer#".$parent."</a>";
				}else{
				echo "Offer";
				}
				?>
				</h2>
				<tr><strong>Item Title:</strong> &nbsp;<a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $rows['listing_id']; ?>"><?php echo $rows['listing_title']; ?></a></tr>
					<tr>
					<td><strong>Item Number:</strong> &nbsp;<?php echo $rows['listing_id']; ?></td>
						<td><strong>Quantity desired:</strong> &nbsp;<?php echo $rows['desired_quantity']; ?></td>
				</tr>
					<tr>
						<td><strong>Trade Credits Included:</strong> &nbsp;$<?php echo $rows['amount_of_trade_credits']; ?></td>
						<td><strong>Cash Included:</strong> &nbsp;$<?php echo $rows['amount_of_cash']; ?></td>
					</tr>
				<tr>
						<td><strong>Total</strong></td>
						<td>$<?php echo ($rows['amount_of_cash']+$rows['amount_of_trade_credits']); ?></td>
					</tr>	
				</table>	
				<?php
				if($user_id == $rows['offered_by'])
				{
				?>
				<br />
				<table border="0" width="60%">
					<tr>
						<td><strong>Seller:</strong></td>
						<td>
							<strong>
                             <?php echo $user_name = ListingHelper::detail('#__users','','username','id',$rows['offered_to'],'','loadresult'); ?>
                            </strong>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<?php
							$get_id = $rows['offered_to'];
							//get user review info
							$db->setQuery("SELECT *
												 FROM #__barter_users_history
												 WHERE user_id = $get_id
												");
							$db->query();
							$userreview = $db->loadAssoc();
							if($userreview['total_reviews'] == 0)
							{
								?>
								<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_name=<?php echo $rows['offered_to']; ?>">(0)</a> reviews with (New)100.00% positive
								<?php
							}
							else
							{
								$review_parcent = ($userreview['total_positive_reviews'] * 100)/$userreview['total_reviews'];
								?>
								<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $rows['offered_to']; ?>">(<?php echo $userreview['total_reviews']; ?>)</a> reviews with <?php echo $review_parcent; ?>% positive
								<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $rows['offered_to']; ?>"><strong>Read all Reviews</strong></a> | 
							<a href="index.php?option=com_listing&view=myaccount&layout=askquestion&seller_id=<?php echo $rows['offered_to']; ?>&listing_id=<?php echo $rows['listing_id']; ?>">Ask seller a question</a> 
						</td>
					</tr>
				</table> 
				<br />
				<p><strong>Comment:</strong> <?php echo $rows['comments']; ?></p>
				<?php
				if($rows['status'] == 'pending')
				{
				?>
					<br />
					<table border="0" width="40%">
						<tr>
							<td>
								<a href="index.php?option=com_listing&view=myaccount&layout=offeredit&offer_id=<?php echo $rows['id']; ?>">Edit</a>
							</td>	
						</tr>
				</table>		
				<?php
				}
				elseif($rows['status'] == 'accepted' AND $rows['is_reviewed_by_buyer'] == 0)
				{
					?>
					<br />
					<table border="0" width="60%">
						<tr>
							<td><a href="index.php?option=com_listing&view=myaccount&layout=givereview&offer_id=<?php echo $rows['id']; ?>">Build the reputation of <strong><?php echo $rows['seller_name']; ?></strong>.</a></td>
						</tr>
					</table>		
					<?php
				}
				if($rows['status'] == 'accepted' AND $rows['is_archived_by_buyer'] == 0)
				{
					?>
					<br />
					<table border="0" width="60%">
						<tr>
							<td><a href="index.php?option=com_listing&viewmyaccount&layout=archive&offer_id=<?php echo $rows['id']; ?>">Archive</a></td>
						</tr>
					</table>		
					<?php
				}
				?>
				<?php
				}
				else
				{
					?>
					<br />
					<table border="0" width="60%">
						<tr>
							<td><strong>Buyer:</strong></td>
							<td>
								<strong><?php echo $rows['buyer_name']; ?></strong>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<?php
								$get_id = $rows['offered_by'];
								//get user review info
								$db->setQuery("SELECT *
													 FROM #__barter_users_history
													 WHERE user_id = $get_id
													");
								$db->query();
								$userreview = $db->loadAssoc();
								if($userreview['total_reviews'] == 0)
								{
									?>
									<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $rows['offered_by']; ?>">(0)</a> reviews with (New)100.00% positive
									<?php
								}
								else
								{
									$review_parcent = ($userreview['total_positive_reviews'] * 100)/$userreview['total_reviews'];
									?>
									<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $rows['offered_by']; ?>">(<?php echo $userreview['total_reviews']; ?>)</a> reviews with <?php echo $review_parcent; ?>% positive
									<?php
								}
								?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<a href="index.php?option=com_listing&view=myaccount&layout=reviews&user_id=<?php echo $rows['buyer_id']; ?>"><strong>Read all Reviews</strong></a> | 
								<a href="index.php?option=com_listing&view=myaccount&layout=askquestion&seller_id=<?php echo $rows['buyer_id']; ?>&listing_id=<?php echo $rows['listing_id']; ?>">Ask buyer a question</a> 
							</td>
						</tr>
					</table> 
					<br />
					<p><strong>Comment:</strong> <?php echo $rows['comments']; ?></p>
					<?php
					if($rows['status'] == 'pending')
					{
						?>
						<br />
						<table border="0" width="40%">
							<tr>
								<td>
									<a href="index.php?option=com_listing&view=myaccount&layout=accept&offer_id=<?php echo $rows['id']; ?>" onclick="return confirm('are you sure you want to accept ?');">Accept</a>
									| <a href="index.php?option=com_listing&view=myaccount&layout=reject&offer_id=<?php echo $rows['id']; ?>" onclick="return confirm('are you sure you want to reject ?');">Reject</a>
									| <a href="index.php?option=com_listing&view=myaccount&layout=counteroffer&offer_id=<?php echo $rows['id']; ?>">Counter-Offer</a>
								</td>	
							</tr>
						</table>		
						<?php
					}
					elseif($rows['status'] == 'accepted' AND $rows['is_reviewed_by_seller'] == 0)
					{
						?>
						<br />
						<table border="0" width="60%">
							<tr>
								<td><a href="index.php?option=com_listing&view=myaccount&layout=givereview&offer_id=<?php echo $rows['id']; ?>">Build the reputation of <strong><?php echo $rows['buyer_name']; ?></strong>.</a></td>
							</tr>
						</table>		
						<?php
					}
					if($rows['status'] == 'accepted' AND $rows['is_archived_by_seller'] == 0)
					{
						?>
						<br />
						<table border="0" width="60%">
							<tr>
								<td><a href="index.php?option=com_listing&view=myaccount&layout=archive&offer_id=<?php echo $rows['id']; ?>">Archive</a></td>
							</tr>
						</table>		
						<?php
					}
				}
				?>
			</div>
			<div class="clear"></div>
		</div>