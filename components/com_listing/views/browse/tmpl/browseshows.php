<?php
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
	$db	=& JFactory::getDBO();
	$category_id = JRequest::getInt('category_id');
	$order_by = JRequest::getWord('order_by');
	//get all category using parent_id	
	$db->setQuery("SELECT * FROM #__barter_category WHERE published = 1 AND parent_id = $category_id order by id");
	$rows = $db->loadObjectList();
	//topMenu();
	//get all parent category for breadcrumbs
	global $finalbreadcrums;
	$finalbreadcrums = '';
	$breadcrumbs = ListingHelper::getAllParentCategory($category_id);
	?>
	<div id="category_list" class="listing">
		<h2><a href="index.php?option=com_listing">Barter Exchange Directory</a><?php echo $breadcrumbs; ?></h2>
	<div class="orderby" style="padding:10px;"><b>Order By:</b> 
	<a href="index.php?option=com_listing&view=browse&layout=browseshow&category_id=<?php echo $category_id; ?>&order_by=price">Price</a> : 
	<a href="index.php?option=com_listing&view=browse&layout=browseshow&category_id=<?php echo $category_id; ?>&order_by=newest">Newest</a> : <a href="index.php?option=com_listing&view=browse&layout=browseshow&category_id=<?php echo $category_id; ?>&order_by=ending">Ending Soon</a> </div>
	<?php
	//order_by
	switch($order_by){
	case price:
	//echo "price";
	$orderBy = "order by sell_price ASC";
	break;
	case newest:
	//echo "newest";
	$orderBy = "order by start_date DESC";
	break;
	case ending:
	//echo "ending";
	$orderBy = "order by end_date ASC";
	break;	
	}?>


		<table width="100%" cellspacing="0" cellpadding="10px" border="0">
			<tr>
				<td>
					<?php
					$total = round(count($rows)/2);
					$i = 0;
					foreach($rows as $row)
					{
						if($i == $total)
						{
							echo "</td><td>";
						}
						global $finaltotal;
						$finaltotal = 0;
						$totalproduct = ListingHelper::countTotalProduct($row->id);
						?>
							<a href="index.php?option=com_listing&&view=browse&layout=showdata&category_id=<?php echo $row->id; ?>"><?php echo $row->category; ?></a>(<?php echo $totalproduct; ?>)<br />
						<?php
						$i++;
					}
					?>
				</td>
			</tr>
		</table>
	</div>
	<?php

	$db->setQuery("SELECT * FROM #__barter_listing WHERE published = 1 AND end_date > $now AND category_id = $category_id $orderBy");
	$listing = $db->loadObjectList();
	if(count($listing) > 0)
	{
		?>
		<div class="listing">
			<table class="wide">
				<thead>                            
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Title</th>
						<th scope="col">From</th>
						<th scope="col">Price</th>
						<th scope="col">Quantity</th>
						<th scope="col">Offers/Bids</th>
						<th scope="col">Posted</th>				
						<th scope="col">Expires in:</th>
					</tr>
				</thead>
				<tbody id="items">
					<?php $i=1;
						foreach($listing as $row)
						{
							?>
							<tr id='post-102' class='alternate'>
								<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
								<td class="centeralign"><a href="index.php?option=com_listing&view=browse&layout=items&item_id=<?php echo $row->id; ?>"><?php echo $row->listing_title; ?></a></td>


<td class="centeralign"><?php //get username of poster
$posterID = $row->user_id;
$user =& JFactory::getUser($posterID);
echo $user->username; ?></td>

								<td class="centeralign"><?php echo $row->sell_price; ?></td>

								<td class="centeralign"><?php echo $row->quantity; ?></td>
								
								<td class="centeralign"><?php echo $row->offer_received; ?></td>

								<td class="centeralign"><?php echo date('m.d.y',$row->start_date); ?></td>
								
								<td class="centeralign">&nbsp- <?php 
								
				$timeLeft = time() - $row->end_date;
				$timeLeft = gmdate('H:i:s', $timeLeft);
				echo $timeLeft;				
				echo "</td>";?>

							</tr>
							<?php
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
		<?php }
	?>
