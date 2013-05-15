<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$database 	 = & JFactory::getDBO();
$category = "SELECT * FROM #__barter_account limit 0,1";
$database->setQuery($category);
$category_detail = $database->loadAssoc();
//print_r($category_detail);die;
JToolBarHelper::custom( 'account.accountupdates', 'save.png', 'save.png', 'Save', false,  false );
?>
  <form action="index.php" method="post" name="adminForm" >
  <table class="admintable" width="700px">
  <tbody>
  <tr>
  <td width="30%" class="key"><label for="message">Comission
  Percent</label></td>
  <td><input class="inputbox" type="text" name="comission_percent"
  id="comission_percent" size="40"
  value="<?php echo $category_detail['comission_percent']; ?>" />
  </td>
  </tr>
	  <tr>
  <td width="30%" class="key"><label for="message">Pay to Paypal Address</label></td>
  <td><input class="inputbox" type="text" name="paypal_api_username"
  id="paypal_address" size="40"
  value="<?php echo $category_detail['paypal_api_username']; ?>" />
  </td>
  </tr>
  <tr>
  <td width="30%" class="key"><label for="message">Payment Title</label>
  </td>
  <td><input class="inputbox" type="text" name="payment_title"
  id="payment_title" size="40"
  value="<?php echo $category_detail['payment_title']; ?>" /></td>
  </tr>
  <tr>
  <td width="30%" class="key"><label for="message">Default User Settings</label>
  </td>
  <td>
  	<input type="radio" <?php if($category_detail['default_user'] == '0') echo 'checked="checked"'; ?> name="user_default" value="0"  /> Active &nbsp;&nbsp;&nbsp;
  	<input type="radio" <?php if($category_detail['default_user'] == '1') echo 'checked="checked"'; ?> name="user_default" value="1" /> Inactive
  </td>
  </tr>
  <tr>
  	<td width="30%" class="key"><label for="message">Email Email From Address</label>
  	<td>
  	<input type="text" name="from_email" value="<?php echo $category_detail['from_email'];?>"> 
  	</td>
  </tr>
  <tr>
  	<td width="30%" class="key"><label for="message">Default From Name</label>
  	<td>
  	<input type="text" name="from_name" value="<?php echo $category_detail['from_name'];?>"> 
  	</td>
  </tr>
  </tbody>
  </table>
 
  <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="account" />
  <input type="hidden" name="task" value=""/>
  <input type="hidden" name="account_id" value="<?php echo $category_detail['id']; ?>">
  </form>
