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
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('homeurl'); ?>
                    <?php echo $this->form->getInput('homeurl'); ?>
                </td>
           </tr>
          
             <tr>
           		<td>
                	<?php echo $this->form->getLabel('start_date'); ?>
                    <?php echo $this->form->getInput('start_date'); ?>
                </td>
           </tr>
            <tr>
           		<td>
                	<?php echo $this->form->getLabel('end_date'); ?>
                    <?php echo $this->form->getInput('end_date'); ?>
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