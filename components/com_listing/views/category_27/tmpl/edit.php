<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//
$data=ListingHelper::getDistinct('#__barter_category','*','where parent_id=0','loadObjectlist');
//echo '<pre>';print_r($data);
?>
<form action="<?php echo JRoute::_('index.php?option=com_listing&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm">
 <div class="width-60 fltlft">     
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parent Category' ); ?></legend>
		<ul class="adminformlist">
        <table>
           <tr>
		<td>Parent Category</td>
        <td>
           <select id="jform_category"  name="jform[category]">
           <?php 
foreach($data as $data1){ 
?>
<option value="<?php echo $data1->category; ?>"<?php if($this->item->category==$data1->category){?> selected="selected"<?php } ?> ><?php echo $data1->category; ?></option>

<?php 

$data_child=ListingHelper::getDistinct('#__barter_category','*','where parent_id='.$data1->id,'loadObjectlist');
//print_r($data_child);
?>
<?php 
foreach($data_child as $data_child1){
?>

<option value="<?php echo $data_child1->category; ?>" <?php if($this->item->category==$data_child1->category){?> selected="selected"<?php } ?>>
<?php 
echo   '|_'.''.$data_child1->category.'';
?></option>

<?php 
}  }
?>
</select></td>
    </tr>
    
    	<tr>
		<td>
    	<?php echo $this->form->getLabel('category');?>
        
        <?php echo $this->form->getInput('category');?>
    	</td>
    </tr>
    
    	
       	<tr>
		<td>
    	<?php echo $this->form->getLabel('published');?>
        
        <?php echo $this->form->getInput('published');?>
    	</td>
    </tr>
 

	
    
   
</table>
</ul>
</fieldset>
</div>
	<div>
		<input type="hidden" name="task" value="category.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
   
</form>