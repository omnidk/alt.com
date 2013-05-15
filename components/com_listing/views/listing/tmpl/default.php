<?php defined('_JEXEC') or die ('restrcted access');

 ?>
<link rel="shortcut icon" href="<?php echo JC_ADMINIMAGE_FOLDER.'/logos';?>">
<table width="100%">
	<tbody>
    	<tr>
        	<td width="55%" valign="top">
            	<div id="cpanel">
				
                  
                    <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.'account','Acount Manager'); ?>
                    <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.CATEGORIES,'Category Manager'); ?>
                
                   <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.LISTING_MANAGERS,'Listing Manager'); ?>
                    <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.USERS,'User Manager'); ?>
                    <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.TRANSACTIONS,'Transaction Manager'); ?>
                    <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.INVOICES,'Invoice Manager'); ?>
                     <?php echo $this->cpanelIcon('', 'index.php?option='.COM_LISTING.'&view='.'broker','Transfer Credit'); ?> 
		</div>
            </td>
            <td width="45%" valign="top">
            
                <div style="float:left; width:45%; text-align:right; text-decoration:none;" class="controllink">

			</div> 
            
            </td>
        </tr>
    </tbody>
</table>