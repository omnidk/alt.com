<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JToolBarHelper::apply('user.user_edit', 'JTOOLBAR_APPLY'); 
JToolBarHelper::save('user.user_edit');
?>
<form action="<?php echo JRoute::_('index.php?option=com_listing&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm">
 <div class="width-60 fltlft">     
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Users' ); ?></legend>
		<ul class="adminformlist">
 		<?php
        $database = & JFactory::getDBO();
		$user_id  = JRequest::getVar('id');
		
		//$userdetails = "SELECT * FROM #__barter_users_history WHERE user_id ='".$user_id."' limit 0,1";
		$userdetails = "select u.name, u.email, u.block, uh.total_balance, uh.line_of_credit from ";
		$userdetails .= "#__users u LEFT JOIN #__barter_users_history uh ON u.id=uh.user_id where uh.id ='".$user_id."' limit 0,1 ";
 
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
						<tr>
							<td width="20%" class="key"><label for="message">Email </label>
							</td>
							<td><input class="inputbox" type="text" name="user_email"
								id="user_email" size="40"
								value="<?php echo $user_detail['email']; ?>" /></td>
						</tr>
						<tr>
							<td width="20%" class="key"><label for="message">Stattus</label>
							</td>
							<td>
								<select name="user_status">
									<option value="0" <?php if($user_detail['block']== '0') echo 'selected="selected"';?>>Unlock</option>
									<option value="1" <?php if($user_detail['block']== '1') echo 'selected="selected"';?>>Block</option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
</ul>
</fieldset>
</div>
	<div>	
		<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
		<input type="hidden" name="task" value="user.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
   
</form>