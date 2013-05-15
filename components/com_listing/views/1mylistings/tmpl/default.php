<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php
 $user =& JFactory::getUser();
 $user_id=$user->get('id');
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
	?>
<?php
    $user=& JFactory::getUser();
	$user_id = $user->get('id');
	$db	=& JFactory::getDBO();	
	//get all listing using user_id
	$db->setQuery("SELECT * FROM #__barter_listing ");
	$listing = $db->loadObjectList();
	ListingHelper::checkLoggedInUser();
	echo ListingHelper::topMenu();
	?>
	<div class="listing">
		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
					<th scope="col">ID</th>
					<th scope="col">Title</th>
					<th scope="col">Quantity</th>
					<th scope="col">Price</th>
					<th scope="col">Views</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody id="items">
				<?php $i=1;
					foreach($listing as $row)
					{
						?>
						<tr id='post-102' class='alternate'>
							<td class="centeralign tdfixedwidth">
							<?php /*?><a href="index.php?option=com_listing&view=mylistings&layout=edit&id=<?php echo $row->id; ?>"><?php  echo $row->id; ?>  </a><?php */?>                           <?php echo $row->id; ?>
							
							</td>
							<td class="centeralign"><?php echo $row->listing_title; ?></td>
							<td class="centeralign"><?php echo $row->quantity; ?></td>
							<td class="centeralign"><?php echo $row->sell_price; ?></td>
						<td class="centeralign"><?php echo $row->total_views; ?></td>
						<td class="centeralign">
						<a href="index.php?option=com_listing&view=mylistings&layout=edit&id=<?php echo $row->id; ?>" rel="permalink">Edit</a>
								&nbsp;
                                <a href="index.php?option=com_listing&task=mylistings.remove&id=<?php echo  $row->id; ?>" rel="permalink">Delete</a>
						<?php /*?><a href="index.php?option=com_listing&view=mylistings&layout=delete&listing_id=<?php echo $row->id; ?>" rel="permalink">Delete</a><?php */?>
							</td>
						</tr>
						<?php
						$i++;
					}
				?>	
			</tbody>
		</table>
	</div>
  <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="mylistings" />
  <input type="hidden" name="task" value=""/>
   <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
  </form>
