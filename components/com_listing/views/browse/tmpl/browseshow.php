<?php
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$now = time();
$db	=& JFactory::getDBO();
echo ListingHelper::topMenu();
$category_id = JRequest::getInt('category_id');
$order_by = JRequest::getWord('order_by');
	//get all category using parent_id	
	$db->setQuery("SELECT * FROM #__barter_category WHERE published = 1 AND parent_id = $category_id order by id");
	$rows = $db->loadObjectList();
	//get all parent category for breadcrumbs
	global $finalbreadcrums;
	$finalbreadcrums = '';
	$breadcrumbs = ListingHelper::getAllParentCategory($category_id);
	?>
	<div id="category_list" class="listing">
		<h2><a href="index.php?option=com_listing&view=browse&layout=browseshow">Barter Exchange Directory</a><?php echo $breadcrumbs; ?></h2>
<p><?php
//get description of this category
$db->setQuery("SELECT * FROM #__barter_category WHERE id = $category_id");
$db->query();
$desc = $db->loadAssoc();
echo $desc['description'];
?></p>
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
							<a href="index.php?option=com_listing&view=browse&layout=browseshow&category_id=<?php echo $row->id; ?>"><?php echo $row->category; ?></a>(<?php echo $totalproduct; ?>)<br />
						<?php
						$i++;
					}
					?>
				</td>
			</tr>
		</table>
	</div>
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
	}

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
				<?php
				//first see if there's any that are featured, if so, show title and run loop
				$feature_count = 0;
				$nonfeature_count = 0;
				
				foreach($listing as $row){
				//if it's featured
					$featured = ListingHelper::isListingFeatured($row->id);
					if($featured == 1){
							$feature_count++;
					}else{
					    $nonfeature_count++;
					}		
				}
				
				if($feature_count > 0){
				echo "<div class=\"featuredlistings\"><b>Featured Listings</b>";
				}
				
				//now show the featured listings					
				$i=1;
				foreach($listing as $row){
					//if it's featured
					$featured = ListingHelper::isListingFeatured($row->id);
					if($featured == 1){
								ListingHelper::showListingRow($row->id);
					}							
				$i++;
				}
				
				if(($feature_count > 0)&&($nonfeature_count > 0)){
					echo "</div></div><div class=\"morelistings\"><b>More Listings</b>";
				}

				$i=1;
				foreach($listing as $row){
				//if it's not featured
						$featured = ListingHelper::isListingFeatured($row->id);
						if($featured == 0){
								ListingHelper::showListingRow($row->id);
						}							
				$i++;
				}
				
				if(($feature_count > 0)&&($nonfeature_count > 0)){
					echo "</div>";
				}
				?>
				</tbody>
			</table>
		</div>
		<?php
	}