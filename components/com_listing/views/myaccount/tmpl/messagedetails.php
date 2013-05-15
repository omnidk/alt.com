<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
?>
<?php
    $message_id = JRequest::getInt('message_id');
	$database 	= & JFactory::getDBO();
	//get user info
	$database->setQuery("SELECT um.id as id,
								um.listing_id as listing_id,
								um.subject as subject,
								um.message as message,
								um.is_read as is_read,
								um.created_date as created_date,
							u.name as full_name
					 FROM #__barter_user_messages um 
					 INNER JOIN #__users u ON u.id = um.sender_id
					 WHERE um.id = $message_id
				");
	$database->query();
	$usermessage = $database->loadAssoc();
	if($usermessage['is_read'] == 0)
	{
	//update total views
	$database->setQuery("UPDATE #__barter_user_messages SET is_read = 1  WHERE id = $message_id");
	$database->query();
	}
	?>
	<div class="listing">
<?php  //userMenu(); ?>
	<div class="right">
		<h3><?php echo $usermessage['subject']; ?></h3>
			<p><?php echo $usermessage['message']; ?></p>
	<table border="0" width="50%">
		<tr>
			<td><strong>Sender Name:</strong> &nbsp;<?php echo $usermessage['full_name']; ?></td>
			<td><strong>Item ID:</strong> &nbsp;<?php echo $usermessage['listing_id']; ?></td>
	</tr>
				<tr>
					<td colspan="2"><strong>Sent Date:</strong> &nbsp;<?php echo $usermessage['created_date']; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><a href="index.php?option=com_listing&view=myaccount&layout=messagereplay&message_id=<?php echo $usermessage['id']; ?>" class="reply">Reply</a></td>
				</tr>
			</table>	



