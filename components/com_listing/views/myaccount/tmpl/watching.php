<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$do = JRequest::getWord('do');
$listing = JRequest::getInt('listing');
$db	=& JFactory::getDBO();
$user =& JFactory::getUser();
$user_id=$user->get('id');
//if any item is sent to watch or unwatch, make it so in the db
//make a listing 'watched'
switch ($do) {
case watch:
  $db->setQuery("INSERT INTO #__barter_listing_watching (`id`, `uid`, `listing_id`) VALUES ('','$user_id','$listing')");
  $db->query();
break;
case unwatch:
  $db->setQuery("DELETE FROM #__barter_listing_watching WHERE uid = $user_id AND listing_id = $listing");
  $db->query();
break;
}

ListingHelper::checkLoggedInUser();
echo ListingHelper::topMenu();

	if($user_id == 0)
	{  
	$msg = JText::_( "Please login....");
			$redirectUrl = base64_encode("index.php?option=com_listing&view=mylistings");
			$version = new JVersion;
            $joomla = $version->getShortVersion();
            if(substr($joomla,0,3) == '1.5'){
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);
            }else{
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);    
            }
			JFactory::getApplication()->redirect($link, $msg);
	 }
 

  $db->setQuery("SELECT * FROM #__barter_listing_watching WHERE uid = $user_id");
  $listing = $db->loadObjectList();
	?>
	<div class="listing">
	<h2>Watching:</h2>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
					<th scope="col">ID</th>
					<th scope="col">Title</th>
					<th scope="col">Quantity</th>
          <th scope="col">Wishlist</th>
					<th scope="col">Price</th>
					<th scope="col">Highest Bid</th>
					<th scope="col">Highest Bidder</th>
					<th scope="col">Auction Ends</th>
				</tr>
			</thead>
			<tbody id="items">
			<?php 
			foreach($listing as $row){
			ListingHelper::showListingRow($row->listing_id);
			//echo "<div>unwatch</div>";
			}
			?>
			</tbody>
		</table>
	</div>
