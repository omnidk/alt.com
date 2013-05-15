<?php
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
$db	=& JFactory::getDBO();
$category_id = JRequest::getInt('category_id');
	//get all category using parent_id	
	$db->setQuery("SELECT * FROM #__barter_category WHERE published = 1 AND parent_id = $category_id order by id");
	$rows = $db->loadObjectList();
	echo ListingHelper::topMenu();
	//get all parent category for breadcrumbs
	global $finalbreadcrums;
	$finalbreadcrums = '';
	$breadcrumbs = ListingHelper::getAllParentCategory($category_id);
	?>
	<div id="category_list" class="listing">
		<h2><a href="index.php?option=com_listing&view=browse&layout=showdata">Barter Exchange Directory</a><?php echo $breadcrumbs; ?></h2>
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
							<a href="index.php?option=com_listing&view=browse&layout=showdata&category_id=<?php echo $row->id; ?>"><?php echo $row->category; ?></a>(<?php echo $totalproduct; ?>)<br />
						<?php
						$i++;
					}
					?>
				</td>
			</tr>
		</table>
	</div>
	<?php
	$db->setQuery("SELECT * FROM #__barter_listing WHERE published = 1 AND category_id = $category_id order by id");
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
						<th scope="col">Price</th>
						<th scope="col">Quantity</th>
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
								<td class="centeralign"><?php echo $row->sell_price; ?></td>
								<td class="centeralign"><?php echo $row->quantity; ?></td>
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



