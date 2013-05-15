<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<form action="<?php echo JRoute::_('index.php?option=com_listing&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" >
 <div class="width-60 fltlft">     
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Listing Manager' ); ?></legend>
		<ul class="adminformlist">
        <table>
				  <?php
  $db =& JFactory::getDBO();	
  $db->setQuery("SELECT * FROM #__users");
  $name = $db->loadObjectList();
   //print_r($name);die;
  ?>
   <?php
  $db=& JFactory::getDBO();	
  $db->setQuery("SELECT * FROM #__barter_users_history");
  $user_name = $db->loadObjectList();
  ?>
   <tr>
  <td><label>Account</label>
  <select name="user_id">
  <option value="1">Select User</option>
  <?php
  
 
  foreach($name as $names)
  {
  ?>
  <option value="<?php echo $names->id; ?>" <?php if($names->id == $row['user_id']){ ?> selected="selected" <?php  } ?>><?php echo $names->name; ?></option>
  <?php
  }
  ?>
  </select>  
  </td>
  </tr>
           <tr>
           		<td>
                	<?php echo $this->form->getLabel('listing_title'); ?>
                    <?php echo $this->form->getInput('listing_title'); ?>
                </td>
           </tr>
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('description'); ?>
                    <?php echo $this->form->getInput('description'); ?>
                </td>
           </tr>
  <?php
  $db	=& JFactory::getDBO();	
  //get all category
  $db->setQuery("SELECT * FROM #__barter_category WHERE parent_id = 0 order by id");
  $categories = $db->loadObjectList();
 // print_r( $categories);die;
  ?>
  <tr>
  <td width="20%" class="key">
  <label for="message">Category</label>
  <select name="category_id">
   <option value="0">Select Category</option>
  <?php
  foreach($categories as $data1){ 
?>
<option value="<?php echo $data1->id; ?>"<?php if($this->item->id==$data1->category_id){?> selected="selected"<?php } ?> ><?php echo $data1->category; ?></option>

<?php 

$data_child=ListingHelper::getDistinct('#__barter_category','*','where parent_id='.$data1->id,'loadObjectlist');

?>
<?php 
foreach($data_child as $data_child1){
?>

<option value="<?php echo $data_child1->id; ?>" <?php if($this->item->id==$data_child1->category_id){?> selected="selected"<?php } ?>>
<?php 
echo   '|_'.''.$data_child1->category.'';
?></option>

<?php 
}  }
?>
</select>
  </td>
  </tr>
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('homeurl'); ?>
                    <?php echo $this->form->getInput('homeurl'); ?>
                </td>
           </tr>
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('paystring'); ?>
                    <?php echo $this->form->getInput('paystring'); ?>
                </td>
           </tr>
             <tr>
           		<td>
                	<?php echo $this->form->getLabel('sell_price'); ?>
                    <?php echo $this->form->getInput('sell_price'); ?>
                </td>
           </tr>
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('shipping_cost'); ?>
                    <?php echo $this->form->getInput('shipping_cost'); ?>
                </td>
           </tr>
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('quantity'); ?>
                    <?php echo $this->form->getInput('quantity'); ?>
                </td>
           </tr>
           
          
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('published'); ?>
                    <?php echo $this->form->getInput('published'); ?>
                </td>
           </tr> 
          
    
           
           
<?php //endforeach; ?>
</table>
		</ul>
	</fieldset>
    </div>
	<div>
		<input type="hidden" name="task" value="listing_manager.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
   
</form>