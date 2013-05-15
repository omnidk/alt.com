<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');



?>
<?php
        $database = & JFactory::getDBO();
		$user_id  = JRequest::getVar('user_id');
		
		$userdetails = "SELECT * FROM #__barter_users_history WHERE user_id ='".$user_id."' limit 0,1";
		$database->setQuery($userdetails);
		$user_detail = $database->loadAssoc(); 
		if(count($user_detail) > 0)
		{
			$edit_user_id = $user_id;
		}
		else
		{
			$edit_user_id = '';
		}
		?>
		<form action="index.php?option=com_listing&task=usersave"
			method="post" name="adminForm" enctype="multipart/form-data">
			<fieldset class="adminform">
				<table class="admintable">
					<tbody>
						<tr>
							<td width="20%" class="key"><label for="message">Balance</label>
							</td>
							<td><input class="inputbox" type="text" name="total_balance"
								id="total_balance" size="40"
								value="<?php echo $user_detail['total_balance']; ?>" /></td>
						</tr>
						<tr>
							<td width="20%" class="key"><label for="message">Line of Credit</label>
							</td>
							<td><input class="inputbox" type="text" name="line_of_credit"
								id="line_of_credit" size="40"
								value="<?php echo $user_detail['line_of_credit']; ?>" /></td>
						</tr>
						<?php /*?><tr>
							<td width="20%" class="key"><label for="message">Broker</label></td>
							<td><select name="broker"><?php 
		$database 	= & JFactory::getDBO();
		$database->setQuery("SELECT u.id as user_id,
                                    u.name as full_name,
									u.email as email,
                                    uh.total_balance as total_balance,
									uh.line_of_credit as line_of_credit,
                                    uh.total_reviews as total_reviews,                                     uh.broker_id as broker_id FROM #__users u LEFT JOIN #__barter_users_history uh ON uh.user_id = u.id");
		$database->query();
		$num_rows = $database->getNumRows();
		$rows = $database->loadObjectList();
		$broker_id = $user_detail['broker_id'];
		
		if($num_rows>0)
		{
					$k = 0;
					$brokerx = $user_detail['broker_id'];
					foreach($rows as $userz)
						{
    					$user_idz = $userz->user_id;
    					$broker =& JFactory::getUser($user_idz);
     					echo "<option value=\"".$user_idz."\" ";
							if($user_idz == $brokerx){
							echo " selected=\"selected\"";
							}							
							echo ">".$broker->name."</option>";
     					$k++;
  					}
		}
 ?>
							</select></td>
						</tr><?php */?>
						<tr>
							<td width="20%" class="key"><label for="published">&nbsp;</label>
							</td>
							<td><input type="submit" name="submit" value="Save"> <input
								type="hidden" name="edit_user_id"
								value="<?php echo $edit_user_id;?>"> <input type="hidden"
								name="user_id" value="<?php echo $user_id;?>"></td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</form>
