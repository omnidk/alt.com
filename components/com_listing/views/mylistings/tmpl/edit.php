<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
$ven_id = JRequest::getVar('id');
$vend_edit = ListingHelper::detail('#__barter_listing','','*','id',$ven_id,'','loadobjectList');
$id=JRequest::getVar('id');
$user=JFactory::getUser();
//print_r($vend_edit);die;
?>
<?php echo ListingHelper::topMenu();?>
<form action="index.php" method="post" name="adminForm">
<?php
foreach($vend_edit as $row){}
  
	?>
	<div class="listing">
		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		                            
			<tr style="background-color:#CCCCCC;">
					<td scope="col">ID</td>
                    <td class="centeralign tdfixedwidth"><?php echo $row->id; ?></td>
                    </tr>
                    <tr>
					<td scope="col">Title</td>
                    <td><input type="text" name="listing_title" value="<?php echo $row->listing_title; ?>" /></td>
                    </tr>
                     <tr>
                     <td scope="col">
                     Description</td>
                      <td>
                      <?php 
                      //$description = $row['description'];
                      $editor =& JFactory::getEditor();
                      echo $editor->display( 'description', "$row->description", '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;
                     ?>
                     </td>
                     </tr>
                      <tr>
					<td scope="col">Website Address</td>
                    <td class="centeralign"><input type="text" name="homeurl" value="<?php echo $row->homeurl; ?>" /></td>
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
                    </td>
                    <td>
                     <select name="category_id">
                    <option value="0">Select Category</option>
                    <?php
                    foreach($categories as $data1){ 
                    ?>
                 <option value="<?php echo $data1->id; ?>"<?php if($data1->id==$row->category_id){?> selected="selected"<?php } ?> ><?php echo $data1->category; ?></option>
                    
                    <?php 
                    
                    $data_child=ListingHelper::getDistinct('#__barter_category','*','where parent_id='.$data1->id,'loadObjectlist');
                    
                    ?>
                    <?php 
                    foreach($data_child as $data_child1){
                    ?>
                    
                    <option value="<?php echo $data_child1->id; ?>" <?php if($data1->id==$row->category_id){?> selected="selected"<?php } ?>>
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
					<td scope="col">Payment types accepted</td>
                    <td class="centeralign"><input type="text" name="paystring" value="<?php echo $row->paystring; ?>" /></td>
                    </tr>
                    <tr>
					<td scope="col">Sell Price</td>
                    <td class="centeralign"><input type="text" name="sell_price" value="<?php echo $row->sell_price; ?>" /></td>
                    </tr>
                     <tr>
					<td scope="col">Shipping Cost</td>
                    <td class="centeralign"><input type="text" name="shipping_cost" value="<?php echo $row->shipping_cost; ?>" /></td>
                    </tr>
                     <tr>
					<td scope="col">Quantity</td>
                    <td class="centeralign"><input type="text" name="shipping_cost" value="<?php echo $row->quantity; ?>" /></td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" value="Submit" /></td>
                    </tr>
			</tbody>
		</table>
	</div>
  <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="mylistings" />
  <input type="hidden" name="task" value="mylistings.save"/>
 <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id; ?>" />
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
  </form>
