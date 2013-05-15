<?php
//browse search results
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$now = time();
$db	=& JFactory::getDBO();
echo ListingHelper::topMenu();
$keyword = JRequest::getString('keyword');
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
		<h2><a href="index.php?option=com_listing&view=browse&layout=browseshow">Barter Exchange Directory Search</a> <?php echo $keyword; ?></h2>
	</div>
	<div class="orderby" style="padding:10px;"><b>Order By:</b> 
	<a href="index.php?option=com_listing&view=browse&layout=browsesearch&keyword=<?php echo $keyword; ?>&order_by=price">Price</a> : 
	<a href="index.php?option=com_listing&view=browse&layout=browsesearch&keyword=<?php echo $keyword; ?>&order_by=newest">Newest</a> : <a href="index.php?option=com_listing&view=browse&layout=browsesearch&keyword=<?php echo $keyword; ?>&order_by=ending">Ending Soon</a></div>
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

$db->setQuery("SELECT * FROM #__barter_listing WHERE ".$where." AND published = 1 AND end_date > $now");
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
		<?php
	}