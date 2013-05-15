<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
echo ListingHelper::topMenu();
?>
<?php
 $user =& JFactory::getUser();
    $user =& JFactory::getUser();
	$user_id=$user->get('id');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
?>
    <div class="listing">
        <div>
    <h2>Invoices</h2>
   <table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" style="line-height:30px">
		<thead>                            
			<tr style="background-color:#CCCCCC;">
    <th nowrap="nowrap">Invoice ID</th>
    <th nowrap="nowrap">Month</th>
    <th nowrap="nowrap">Total Due</th>
    <th nowrap="nowrap">Paid</th>
    <th nowrap="nowrap">Paid Date</th>
    </tr>
    </thead>
    <tbody><?php					
    $database 	= & JFactory::getDBO();
    $database->setQuery("SELECT * FROM #__barter_invoices WHERE uid = $user_id ORDER BY ndx DESC");
    $database->query();
    $num_rows = $database->getNumRows();
    $rows = $database->loadObjectList();
    $k = 0;
    foreach($rows as $invoice)
    {
    ?>
    <tr class="<?php echo "row$k"; ?>">
    <td>
    <?php 
    $ndx = $invoice->ndx; echo "<a href=\"index.php?option=com_listing&view=myaccount&layout=viewinvoice&invoiceID=".$ndx."\">".$invoice->ndx."</a>"; ?>
    </td>
    <td>
    <?php 
    $month = $invoice->month;
    $month =ListingHelper:: GetMonthString($month);
    echo $month; ?>
    </td>
    <td>
    <?php echo "$";echo $invoice->amt; ?>
    </td>
    <td>
    <?php 
    if($invoice->paid == 1){
    echo "x";
    }?>
    </td>
    <td>
    <?php 
    if($invoice->paidDate != 0){
    $paidDate = date("m.d.y", $invoice->paidDate);
    echo $paidDate;								
    }?>
    <?php //echo $user->paidDate; ?>
    </td>
    </tr>	
    <?php
    $k = 1 + $k;
    }
    ?>
    </tbody>
    </table></div></div>



