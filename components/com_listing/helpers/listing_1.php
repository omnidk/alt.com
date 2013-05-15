<?php

defined('_JEXEC') or die;


class ListingHelper
{
	
		function getDistinct($table,$col,$where,$resulttype)
		 {
		// echo 'hiii';die;
				 $db=JFactory::getDBO();
				 
			  $sql="select $col from $table $where"; 
				 
				 $db->setQuery($sql);
				 
				 $r=$db->$resulttype(); 
				
				 return $r;
		 
		 }
		 
		
		 
		 
		 function detail($table,$start,$column,$col,$val,$end,$resulttype)
		{
			$db=JFactory::getDBO();
			
			if($val=='')
			{
			$where='';
			}
			else
			{
			$where="where ".$col."=".$val." ";
			}
			
			$sql="select ".$start." ".$column." from ".$table." ".$where." ".$end."";
			$db->setQuery($sql);
			$res=$db->$resulttype();
			return $res;
		
		}
		
		
		 function getDistinctvalue($table,$col,$where,$resulttype)
		 {
				 $db=JFactory::getDBO();
				 
			 	 $sql="select distinct $col from $table $where"; 
				 
				 $db->setQuery($sql);
				 
				 $r=$db->$resulttype();
				 
				 return $r;
		 
		 }
		 
		 function userMenu()
        {



   echo '			<div class="left">



				<ul class="account_menu">



					<li><a href="index.php?option=com_listing&view=myaccount&layout=inbox">Inbox</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=sentmessage">Sent Message</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=receivedoffer">Received Offer</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=archivedoffer">Archived Offer</a></li>
					
					
					<li><a href="index.php?option=com_listing&view=myaccount&layout=sentoffer">Sent Offer</a></li>

					

					<li><a href="index.php?option=com_listing&view=myaccount&layout=salescredits">Sales History</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=purchasecredits">Purchase History</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=receivedcredits">Received Credits</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=sentcredits">Sent Credits</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=transfer">Transfer Credits</a></li>

					

					<li><a href="index.php?option=com_listing&view=myaccount&layout=cash2credits">Cash to Credits</a></li>



					<li><a href="index.php?option=com_listing&view=myaccount&layout=invoices">Invoices</a></li>



				</ul>



			</div>';



}


function topMenu()



{



//snippet to trigger the reward - to be added anywhere within joomla

//$reward = "1";//how many credits to give user for this action

//require_once('components/com_listing/index.php?option=com_listing&task=credits4participation&amt='.$reward.'&'. JUtility::getToken() .'=1');



	echo '<div id="l_top_menu">



			<ul>



				<a href="index.php?option=com_listing&view=browse">Browse</a>



				<a href="index.php?option=com_listing&view=post">Post</a>



				<a href="index.php?option=com_listing&view=mylistings">My Listings</a>



				<a href="index.php?option=com_listing&view=myaccount">My Account</a>



			</ul>



		</div>';



}

function getAllParentCategory($category_id)



{



	$database 	= & JFactory::getDBO();



	global $finalbreadcrums;



	//get category details



	$database->setQuery("SELECT * FROM #__barter_category WHERE id=" . $category_id);



	$result = $database->loadAssoc();



	$category_id = $result['id'];



	$parent_id   = $result['parent_id'];



	$category    = $result['category'];



	$finalbreadcrums = "&raquo;<a href='index.php?option=com_listing&view=browse&layout=showdata&category_id=$category_id'>$category</a>".$finalbreadcrums;



	



	if($parent_id != 0)



	{



		ListingHelper::getAllParentCategory($parent_id);



	}



	return $finalbreadcrums;



}

function countTotalProduct($category_id)



{



	$database 	= & JFactory::getDBO();



	global $finaltotal;



	//count total product for first category



	$database->setQuery("SELECT count(id) as total FROM #__barter_listing WHERE published = 1 AND category_id=" . $category_id);



	$result        = $database->loadAssoc();



	$totalpro      = $result['total'];



	$finaltotal = $finaltotal + $totalpro;



	//get child category



	$database->setQuery("SELECT * FROM #__barter_category WHERE parent_id=" . $category_id);



	$database->query();



	$rows= $database->loadObjectList(); 
//print_r($rows);die;


	foreach($rows as $row)



	{
		ListingHelper::countTotalProduct($row->id); 

	}

	return $finaltotal;



}
function checkLoggedInUser()



{



	$user =& JFactory::getUser();



	$user_id=$user->get('id');



	if($user_id == 0)



	{



		die(header('Location: index.php?option=com_users&view=login'));



	}



}

function GetMonthString($n)



{



    $timestamp = mktime(0, 0, 0, $n, 1, 2005);



    



    return date("M", $timestamp);



}

function getUserId($username)
{
        // Initialize some variables
        $db = & JFactory::getDBO();
 
        $query = 'SELECT id FROM #__users WHERE username = ' . $db->Quote( $username );
        $db->setQuery($query, 0, 1);
        return $db->loadResult();
}

function request_email($data,$recievermail,$senderName)
		{
			$db = JFactory::getDBO();
			
		//print_r($_POST);die;
			//$user=JFactory::getUser();
			//echo $user->id;die;
			$mainframe		=& JFactory::getApplication();
			$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
			$fromname 		= $mainframe->getCfg( 'fromname' );
			
			$emailSubject=JText::sprintf($senderName. ' sent you credits!');
			$emailBody=JText::sprintf(
			'<table width="500px" style="border:1px solid;">
			<tr>
			<td><b>Sender Name:</b></td>
			<td>'.$data['from'].'</td>
			</tr>
			<tr>
			<td><b>Amount</b></td>
			<td>'.$data['amount'].'</td>
			</tr>						
			<tr>
			<td><b>Comment</b></td>
			<td>'.$data['comments'].'</td>
		    </tr>
			' );
			//print_r($recievermail);die;
			$return = JUtility::sendMail($mailfrom,$fromname,$recievermail,$emailSubject,$emailBody,'1');
				
							
			return true;
		}

}
