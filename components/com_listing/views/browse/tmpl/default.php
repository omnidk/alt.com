<?php
defined('_JEXEC') or die;
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$now = time();
$user =& JFactory::getUser();
$user_id=$user->get('id');
$db	=& JFactory::getDBO();
$category_id = JRequest::getInt('category_id');
	//get all category using parent_id	
	$db->setQuery("SELECT * FROM #__barter_category WHERE published = 1 AND parent_id = $category_id order by id");
	$rows = $db->loadObjectList();
	echo ListingHelper::topMenu();
	//get all parent category for breadcrumbs
	global $finalbreadcrums;
	$finalbreadcrums = '';
	$breadcrumbs =ListingHelper::getAllParentCategory($category_id);
	?>
	<div id="category_list" class="listing">
		<h2><a href="index.php?option=com_listing&view=browse">Barter Exchange Directory</a><?php echo $breadcrumbs; ?></h2>
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

