<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php /*?><?php echo ListingHelper:: userMenu(); ?><?php */?>
<?php

   ListingHelper::checkLoggedInUser();
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	echo ListingHelper::topMenu();	
	$db = JFactory::getDBO();
	//$query = "SELECT * FROM #__barter_user_messages";
	//$query .=" WHERE receiver_id = ".$user_id;
	
	$query = "select *,(select name from #__users where id = um.receiver_id) as fullname from #__barter_user_messages um where receiver_id = '$user_id'";
	
	$db->setQuery($query);
	$usermessage = $db->loadObjectlist();
	///$database 	= & JFactory::getDBO();
	//get user info
	//$database->setQuery("SELECT um.id as id,
								//um.listing_id as listing_id,
								//um.subject as subject,
								//um.message as message,
								//um.is_read as is_read,
								//um.created_date as created_date,
								//u.name as full_name
						// FROM #__barter_user_messages um 
						 //INNER JOIN #__users u ON u.id = um.sender_id
						 //WHERE um.receiver_id = $user_id
						//");
	//$database->query();
	//$usermessage = $database->loadObjectList();
	//print_r($usermessage );die;
	?>
	<div class="listing">
		<div class="right">
			<h2>Inbox Message</h2>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th scope="col">ID</th>
						<th scope="col">From</th>
						<th scope="col">Item</th>
						<th scope="col">Subject</th>
					</tr>
				</thead>
				<tbody id="items">
					<?php $i=1;
						foreach($usermessage as $row)
						{
							if($row->is_read == 0)
							{
								$read = 'unread';
							}
							?>
							<tr id='post-102' class='alternate <?php echo $read; ?>'>
								<td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
								<td class="centeralign"><?php  $row->sender_id ; ?>
                                 <?php echo $user_name = ListingHelper::detail('#__users','','username','id',$row->sender_id,'','loadresult'); ?>
                                </td>
								<td class="centeralign"><?php  $row->listing_id; ?>
                                 <?php echo $user_title = ListingHelper::detail('#__barter_listing','','listing_title','id',$row->listing_id,'','loadresult'); ?>
                                </td>
								<td class="centeralign"><a href="index.php?option=com_listing&view=myaccount&layout=messagedetails&message_id=<?php echo $row->id; ?>"><?php echo $row->subject; ?></a></td>
							</tr>
							<?php
							$i++;
						}
					?>	
				</tbody>
			</table>
		</div>
		<div class="clear"></div>
	</div>

