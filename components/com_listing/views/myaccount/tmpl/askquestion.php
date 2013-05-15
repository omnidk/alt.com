<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");

  $database   = & JFactory::getDBO();
	$seller_id = JRequest::getInt('seller_id');
	$buyer_id = JRequest::getInt('buyer_id');
	if($seller_id != ""){
	$toUid = $seller_id;
	$subject = "Question for seller";
	}else{
	$toUid = $buyer_id;
	$subject = "Question for buyer";
	}
	$listing_id = JRequest::getInt('listing_id');
	$success = JRequest::getInt('success');	
	$userdetails = "SELECT * FROM #__users WHERE id ='".$toUid."' limit 0,1";
	$database->setQuery($userdetails);
	$user_detail = $database->loadAssoc(); 
	$itemdetails = "SELECT * FROM #__barter_listing WHERE id ='".$listing_id."' limit 0,1";
	$database->setQuery($itemdetails);
	$itemdetails = $database->loadAssoc(); 
	if(isset($listing_id)){
	$subject = "Question about ".$itemdetails['listing_title']."";
	}
	echo ListingHelper::topMenu();
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
								<label for="message">To</label>
							</td>
							<td>
								<input class="inputbox" type="text" readonly="readonly" name="receiver_username" id="username" size="40" value="<?php echo $user_detail['username']; ?>" />
							</td>
						</tr>
						<tr>
							<td width="20%" class="key">
								<label for="message">Item (if any)</label>
							</td>
							<td>
								<input class="inputbox" type="text" readonly="readonly" name="listing_title" id="listing_title" size="40" value="<?php echo $itemdetails['listing_title']; ?>" />
							</td>
						</tr>
						<tr>
							<td width="20%" class="key">
								<label for="message">Subject</label>
							</td>
							<td>
								<input class="inputbox" type="text" name="subject" id="subject" size="40" value="<?php echo $subject; ?>" />
							</td>
						</tr>
						<tr>
							<td width="20%" class="key">
								<label for="message">Message</label>
							</td>
							<td>
								<textarea id="message" name="message" cols="30" rows="5"></textarea>
							</td>
						</tr>
                        
						<tr>
							<td width="20%" class="key">
								<label for="published">&nbsp;</label>
							</td>
							<td>
								<input type="submit" name="submit" value="Submit">
								<input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
								<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
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

