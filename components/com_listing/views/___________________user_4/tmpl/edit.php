<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//echo "dsdsd";die;
?>
<form action="<?php echo JRoute::_('index.php?option=com_listing&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm">
 <div class="width-60 fltlft">     
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Users' ); ?></legend>
		<ul class="adminformlist">
        <table>
           <tr>
		<td>
    	<?php echo $this->form->getLabel('total_balance');?>
        
        <?php echo $this->form->getInput('total_balance');?>
    	</td>
    </tr>
       	<tr>
		<td>
    	<?php echo $this->form->getLabel('line_of_credit');?>
        
        <?php echo $this->form->getInput('line_of_credit');?>
    	</td>
    </tr>
 

	<tr>
		<td>
    	<?php echo $this->form->getLabel('broker_id');?>
        
        <?php echo $this->form->getInput('broker_id');?>
    	</td>
    </tr>
    
	
    
   
</table>
</ul>
</fieldset>
</div>
	<div>
		<input type="hidden" name="task" value="user.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
   
</form>