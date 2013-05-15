<?php
defined('_JEXEC') or die('Restricted Error');
JToolBarHelper :: custom( 'user.save2', 'save.png', 'save.png', 'Save', false,false);
?>
  <?php
  $db =& JFactory::getDBO();
  $db->setQuery("SELECT * FROM #__users");
  $name = $db->loadObjectList();
   //print_r($name);die;
  ?>
   <?php
  $db=& JFactory::getDBO();
   $db->setQuery("SELECT * FROM #__users");
  $user_name = $db->loadObjectList();
  ?>
<form method="post" action="index.php"  name="adminForm"  >
  <table class="admintable">
   <tr>
  <td>User name</td>
  <td>
   <select name="user_id">
  <option value="0">Select User</option>
  <?php


  foreach($name as $names)
  {
  ?>
  <option value="<?php echo $names->id; ?>"><?php echo $names->username; ?></option>
  <?php
  }
  ?>
  </select>

  </td>
  </tr>
  <tr>
  <td>Broker name</td>
  <td>
   <select name="broker_id">
  <option value="0">Select broker</option>
  <?php
  foreach($user_name as $user_names)
  {
  ?>
  <option value="<?php echo $user_names->id; ?>" ><?php echo $user_names->username ; ?></option>
  <?php
  }
  ?>
  </select>
  </td>
  </tr>
  <tr>
  <td>total balance
  </td>
  <td>
  <input type="text" name="total_balance" />
  </td>
  </tr>
  <tr>
  <td>line of credit
  </td>
  <td>
  <input type="text" name="line_of_credit" />
  </td>
  </tr>
   </table>
  <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="user" />
  <input type="hidden" name="task" value="user_add.save2"/>
  </form>