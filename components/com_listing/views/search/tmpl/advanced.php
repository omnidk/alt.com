<?php
//browse search results
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$now = time();
$db	=& JFactory::getDBO();
echo ListingHelper::topMenu();
$keyword = JRequest::getString('keyword');
$seller = JRequest::getString('seller');
$min = JRequest::getFloat('min');
$max = JRequest::getFloat('max');
$madeinamerica = JRequest::getBool('madeinamerica');
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
		<h2><a href="index.php?option=com_listing&view=search&layout=advanced">Advanced Search</a></h2>
	</div>
	<style>
	.key{ width:100px; }
	</style>
	<div style="width:500px; padding:10px; padding-bottom:30px;">
		<form method="post" action="index.php/component/listing/?view=search&layout=advanced">
						<fieldset class="adminform">
					<table class="admintable">
						<tbody>
							<tr>
								<td class="key">
									<label for="message">Search For:</label>
							  </td>
								<td><input type="text" name="keyword" style="float:left; clear:none;"/></td>
								<td class="key">
									<label for="message">From Seller:</label>
							  </td>
								<td><input type="text" name="seller" style="float:left; clear:none;"/></td>
							</tr>
							<tr>
								<td class="key">
									<label for="message">Price Range:</label>
							  </td>
								<td><input type="text" name="min" value="min" style="float:left; clear:none;"/><input type="text" name="max" value="max" style="float:left; clear:none;"/></td>
								<td class="key">
									<label for="message">Made in America:</label>
							  </td>
								<td><input type="checkbox" name="madeinamerica" style="float:left; clear:none;"/></td>
							</tr>							
<tr>
<td></td>
<td></td>
<td></td>
<td>
		<input type="submit" name="submit" value="Search" style="float:right; clear:none;"/>
</td></tr>
</tbody></table>
		</form>
	</div>
	<!--
	The ability to search listings instead of just browsing through the categories.  Search options would include:
X a.       Search for terms within the title and description
b.      Search for items listed by a specific seller
c.       Search for items in a specific price range
d.      Include only items of a certain type in the search results, such as only those with buy it now, only those that accept offers, or only those that are auctions. 
	-->
	<!--<div class="orderby" style="padding:10px;"><b>Order By:</b> 
	<a href="index.php?option=com_listing&view=browse&layout=browsesearch&keyword=<?php echo $keyword; ?>&order_by=price">Price</a> : 
	<a href="index.php?option=com_listing&view=browse&layout=browsesearch&keyword=<?php echo $keyword; ?>&order_by=newest">Newest</a> : <a href="index.php?option=com_listing&view=browse&layout=browsesearch&keyword=<?php echo $keyword; ?>&order_by=ending">Ending Soon</a></div>-->
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

//break it up into multiple pieces if it's got multiple keywords in it
$text = $keyword;
$words  = explode( ' ', $text );
$wheres = array();

//run a where tablename is like %word%
foreach ($words as $word){
	$word = $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
  $wheres2 = array();
  $wheres2[] = '`listing_title` LIKE '.$word;
	$wheres2[]	= '`description` LIKE '.$word;
  $wheres[] = implode( ' OR ', $wheres2 );
}
$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';

if($seller != ""){ 
  //get seller uid
  $db->setQuery("SELECT id FROM #__users WHERE `username` = '$seller'");
  $sellerid = $db->loadResult(); 
  //echo $id; die;
  if ($sellerid == 0) {
    echo "<p>There is no user ".$seller." registered on this site.</p>";
  } else {
  	$and = "AND user_id = ".$sellerid;
  }
}

if($min != "") { $and = $and." AND sell_price > ".$min; }
if($max != "") { $and = $and." AND sell_price < ".$max; }

if($madeinamerica == 1){ $and = $and." AND made_in_america = 1"; }

if($keyword != ""){//run the search

$db->setQuery("SELECT * FROM #__barter_listing WHERE ".$where." ".$and." AND published = 1 AND end_date > $now");
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
						$i=1;
						foreach($listing as $row){
								//if it's featured
								$featured = ListingHelper::isListingFeatured($row->id);
								if($featured == 1){
										ListingHelper::showListingRow($row->id);
								}							
						$i++;
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
					?>
				</tbody>
			</table>
		</div>
		<?php
	}else{ echo "<b>There are no results to display.</b>"; }
	}//keyword not set