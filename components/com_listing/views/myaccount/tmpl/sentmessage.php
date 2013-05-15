<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php /*?><?php echo ListingHelper:: userMenu(); ?><?php */?>
<?php
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	echo ListingHelper::topMenu();	
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
	$database 	= & JFactory::getDBO();
	//get user info
	/*
	$database->setQuery("SELECT um.id as id,
								um.listing_id as listing_id,
								um.subject as subject,
								um.message as message,
								um.is_read as is_read,
								um.created_date as created_date,
								u.name as full_name
						 FROM #__barter_user_messages um 
						 INNER JOIN #__users u ON u.id = um.receiver_id
						 WHERE um.sender_id = $user_id
						");
	*/
	//$database->setQuery("select *,(select name from #__users where id='$user_id') as fullname from #__barter_user_messages where sender_id = '$user_id'");	
	$database->setQuery("select *,(select name from #__users where id = um.receiver_id) as fullname from #__barter_user_messages um where sender_id = '$user_id'");	
	
				
	$row = $database->query();
	$usermessage = $database->loadObjectList();
	//print_r($usermessage);die;
	?>
	<div class="listing">
		<div class="right">
		<h2>Sent Message</h2>
		 <table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
						<th>ID</th>
						<th>To</th>
						<th>Item</th>
						<th>Subject</th>
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
								<td class="centeralign"><?php echo $row->fullname; ?></td>
								<td class="centeralign"><?php echo $row->listing_id; ?></td>
								<td class="centeralign"><?php echo $row->subject; ?></td>
							</tr>
							<?php
							$i++;
						}
					?>	
				</tbody>
			</table>
</div></div>


