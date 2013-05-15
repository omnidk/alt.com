<?php
defined('_JEXEC') or die('Restricted Error');
JToolBarHelper :: custom( 'user.save1', 'save.png', 'save.png', 'Save', false,false);

?>
<script type="text/javascript">
function valid()
{
     var password=document.getElementById("password").value;
     var confirm_password=document.getElementById("confirm_password").value;
	 if(password!=confirm_password)
  {
  alert("password not matched");
  document.getElementById("password").focus();
  document.getElementById('password').style.borderColor="red";
  return false;
  }
   return true;
}
</script>
<form method="post" action="index.php"  name="adminForm"  >
  <table class="admintable">
  <tr>
  <td>Name</td>
  <td><input type="text" name="name" /></td>
  </tr>
   <tr>
  <td>User name</td>
  <td><input type="text" name="username" /></td>
  </tr>
   <tr>
  <td>password</td>
  <td><input type="password" name="password" /></td>
  </tr>
   <tr>
  <td>Email</td>
  <td><input type="text" name="email" /></td>
  </tr>
  <?php /*?> <tr>
            	<td colspan="3">
                	<input class="update-btn" type="submit" value="Save" name="save"/>
                    
                </td>
                
            </tr><?php */?>
   </table>
    <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="user" />
  <input type="hidden" name="task" value="user.save1"/>
  
   
  </form>
