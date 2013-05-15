<?php  defined ('_JEXEC') or die ('Restricted Acess');
	JToolBarHelper::custom( 'broker.save', 'save.png', 'save.png', 'Save', false,  false );
 ?>
 <script type="text/javascript">
<!--
function validateForm()
{
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
		Joomla.submitbutton('broker.save');
	else
		return false ;
}
	document.getElementById('toolbar-save').innerHTML = '';
	var btnText = '<a class="toolbar" onclick="validateForm()" href="#"><span class="icon-32-save"></span>Save</a>';
	document.getElementById('toolbar-save').innerHTML = btnText;
//-->
</script>
<form action="index.php"  method="post" name="adminForm" enctype="multipart/form-data">
  <fieldset class="adminform">
  <table class="admintable">
  <tbody>
  <tr>
  <td width="20%" class="key"><label for="message">Transfer Amount</label>
  </td>
  <td><input class="inputbox" type="text" name="amount" id="amount"
  size="40" value="" /></td>
  </tr>
  <tr>
  <td width="20%" class="key"><label for="message">From</label></td>
  <td><input class="inputbox" type="text" name="from" id="from"
  size="40" value="" /></td>
  </tr>
  <tr>
  <td width="20%" class="key"><label for="message">To</label></td>
  <td><input class="inputbox" type="text" name="to" id="to"
  size="40" value="" /></td>
  </tr>
  <tr>
  <td width="20%" class="key"><label for="message">Comment</label>
  </td>
  <td><input class="inputbox" type="text" name="comments"
  id="comments" size="40" value="" /></td>
  </tr>
  </tbody>
  </table>
  </fieldset>
		
<input type="hidden" name="option"  value="com_listing"/>
<input type="hidden" name="controller" value="broker" />
<input type="hidden" name="task" value=""/>
<input type="hidden" name="account_id" value="<?php echo $category_detail['id']; ?>">
</form>