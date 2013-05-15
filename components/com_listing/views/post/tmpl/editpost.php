<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
?>
<?php
/*$user=JFactory::getUser();
$url=JURI::base();
if(!$user->id)
{
	echo "You must login before Proceed  ";?><a href="<?php echo $url;?>">login</a>
    die(header('Location: index.php?option=com_user&view=login'));
    <?php return false;
}*/
 $user =& JFactory::getUser();
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
	//$link = JRoute::_('index.php?option=com_listing&view=post');
    //$this->setRedirect($link);
	?>
    
  <form method="post" action="index.php"  name="adminForm" >
  <table class="admintable">
  <tbody>
  <tr>
  <td width="20%" class="key">
  <label for="message">Listing Title</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="listing_title" id="listing_title" size="40" />
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="message">Description</label>
  </td>
  <td>
  <?php 
  //$description = $row['description'];
  $editor =& JFactory::getEditor();
  echo $editor->display( 'description', "", '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;
  ?>
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="message">Website Address</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="homeurl" id="homeurl" size="40"  />
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
  </td>
  <td>
  <select name="category_id">
  <option value="0">Select Category</option>
  <?php
  foreach($categories as $category)
  {
  ?>
  <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $row['category_id'])? 'selected="selected"' : ''; ?>><?php echo $category->category; ?></option>
  <?php
 // showSubCategories($category->id,'',$category->parent_id);    
  }
  ?>
  </select>
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="message">Payment types accepted</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="paystring" id="paystring" size="40"  />
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="message">Sell Price</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="sell_price" id="sell_price" size="40"  />
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="message">Shipping Cost</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="shipping_cost" id="shipping_cost" size="40"  />
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="message">Quantity</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="quantity" id="quantity" size="40"  />
  <input type="checkbox" name="persistent" <?php echo ($row->persistent == 1)? 'checked="checked"' : ''; ?> value="1">Make this a Persistent Listing
  </td>
  </tr>
  <tr>
  <td width="20%" class="key">
  <label for="published">&nbsp;</label>
  </td>
  <td>
  <input type="submit" name="submit" value="Submit">
  </td>
  </tr>
  </tbody>
  </table>
 
  <input type="hidden" name="option"  value="com_listing"/>
  <input type="hidden" name="controller" value="post" />
  <input type="hidden" name="task" value="post.save"/>
   <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
  </form>
