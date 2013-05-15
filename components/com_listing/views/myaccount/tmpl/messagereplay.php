<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<?php echo ListingHelper:: userMenu(); ?>
<?php

    ListingHelper::checkLoggedInUser();
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	$db	=& JFactory::getDBO();
	$message_id		= JRequest::getVar('message_id');
	/*
	$query = "select * from #__barter_user_messages where id = '$message_id' limit 0,1";
	//echo $query;
	//subject message listing_id 
	$db->setQuery($query);
	$rows = $db->loadObjectlist();
	$usermessage = $db->loadObjectList();
	print_r($rows);
	*/

	$db->setQuery("select *,(select name from #__users u where um.receiver_id = u.id) as fullname from #__barter_user_messages um where um.id = '$message_id'");
	$rows = $db->loadAssoc();
	//print_r($rows);
	
	$success = "";
	//topMenu();
	?>
	<div id="ask_question" class="listing">
		<?php
		if($success == 1)
		{
			echo "<h2>Your message has been sent successfully!</h2>";
		}
		?>
		<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
			<fieldset class="adminform">
				<table class="admintable">
					<tbody>
						<tr>
							<td width="20%" class="key">
								<label for="message">To (username or id)</label>
							</td>
							<td>
								<input class="inputbox" type="text" readonly="readonly" name="receiver_username" id="username" size="40" value="<?php echo $rows['fullname'];?>" />
							</td>
						</tr>
						<tr>
							<td width="20%" class="key">
								<label for="message">Item (if any)</label>
							</td>
							<td>
								<input class="inputbox" type="text" readonly="readonly" name="listing_title" id="listing_title" size="40" value="" />
							</td>
						</tr>
						<tr>
							<td width="20%" class="key">
								<label for="message">Subject</label>
							</td>
							<td>
								<input class="inputbox" type="text" name="subject" id="subject" size="40" value="<?php echo $rows['subject'];?>" />
							</td>
						</tr>
						<tr>
							<td width="20%" class="key">
								<label for="message">Message</label>
							</td>
							<td>
								<textarea id="message" name="message" cols="30" rows="5"><?php echo $rows['message'];?></textarea>
							</td>
						</tr>
                        
						<tr>
							<td width="20%" class="key">
								<label for="published">&nbsp;</label>
							</td>
							<td>
								<input type="submit" name="submit" value="Submit">
								<input type="hidden" name="seller_id" value="<?php echo $rows['receiver_id']; ?>">
								<input type="hidden" name="listing_id" value="<?php echo $rows['listing_id']; ?>">
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		    <input type="hidden" name="option"  value="com_listing"/>
		    <input type="hidden" name="controller" value="myaccount" />
		    <input type="hidden" name="task" value="myaccount.save1"/>
		   <input type="hidden" name="username" />
		</form>
	</div>