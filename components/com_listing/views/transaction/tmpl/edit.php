<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<form action="<?php echo JRoute::_('index.php?option=com_listing&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm">
 <div class="width-60 fltlft">     
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Transaction' ); ?></legend>
		<ul class="adminformlist">
        <table>
           <tr>
		<td>
    	<?php echo $this->form->getLabel('sender_id');?>
        
        <?php echo $this->form->getInput('sender_id');?>
    	</td>
    </tr>
       	<tr>
		<td>
    	<?php echo $this->form->getLabel('receiver_id');?>
        
        <?php echo $this->form->getInput('receiver_id');?>
    	</td>
    </tr>
    	<tr>
		<td>
    	<?php echo $this->form->getLabel('amount');?>
        
        <?php echo $this->form->getInput('amount');?>
    	</td>
    </tr>

	<tr>
		<td>
    	<?php echo $this->form->getLabel('from_total_balance');?>
        
        <?php echo $this->form->getInput('from_total_balance');?>
    	</td>
    </tr>
    <tr>
		<td>
    	<?php echo $this->form->getLabel('from_line_of_credit');?>
        
        <?php echo $this->form->getInput('from_line_of_credit');?>
    	</td>
    </tr>
	
     <tr>
		<td>
    	<?php echo $this->form->getLabel('created_date');?>
        
        <?php echo $this->form->getInput('created_date');?>
    	</td>
    </tr>
    <tr>
           		<td>
                	<?php echo $this->form->getLabel('published'); ?>
                    <?php echo $this->form->getInput('published'); ?>
                </td>
           </tr> 
</table>
</ul>
</fieldset>
</div>
	<div>
		<input type="hidden" name="task" value="transaction.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
   
</form>