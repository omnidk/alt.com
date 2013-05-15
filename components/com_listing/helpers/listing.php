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

function countTotalProduct($category_id){

	$database 	= & JFactory::getDBO();

	global $finaltotal;

	//count total product for first category
	$now = time();

	$database->setQuery("SELECT count(id) as total FROM #__barter_listing WHERE published = 1 AND end_date > $now AND category_id=" . $category_id);

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

function checkLoggedInUser(){
	$user =& JFactory::getUser();
	$user_id=$user->get('id');
	if($user_id == 0)
	{
		die(header('Location: index.php?option=com_users&view=login'));
	}
}

function GetMonthString($n){

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
		
		
function createJoomlaUser($name,$username,$email, $password)	{		
						
						JTable::addIncludePath(JPATH_ROOT.DS.'libraries'.DS.'joomla'.DS.'database'.DS.'table');
						jimport('joomla.application.component.helper');
						jimport('joomla.user.helper');
						$db=JFactory::getDBO();
						$session=JFactory::getSession();
						$salt  = JUserHelper::genRandomPassword(32);
						//$session->set('password', $password_clear);
						$crypt = JUserHelper::getCryptedPassword($password, $salt);
						$password = $crypt.':'.$salt;
						$user = array();
						 $user['name'] = $name;
						$user['username'] = $username;
						$user['email'] = $email;
						$user['password'] = $password;
						 
						$user['block'] = 0; 
						//$user['sendEmail']=1;
						//$user['params']=$params; 
						//$user['activation']=$link_activ; 
						//$user['aatia_id']=$aatia_id;
						//die;
						$instance = JUser::getInstance();
						
						$config = JComponentHelper::getParams('com_users');
						//$defaultUserGroup = $config->get('Aatia', 88);
						$defaultUserGroup = $config->get('new_usertype', 2);
					//	print_r($defaultUserGroup);die;
						$acl = JFactory::getACL();
						$instance->set('id'         , 0);
						
						$instance->set('name'           , $user['name']);
						$instance->set('username'       , $user['username']);
						$instance->set('password' , $user['password']);
						$instance->set('email'          , $user['email']);  // Result should contain an email (check)
						$instance->set('usertype'       , 'Listing');
						$instance->set('block'       , $user['block']);
						
						
						//$instance->set('params'       , $user['params']);
					//	$instance->set('activation'       , $user['activation']);
						$instance->set('groups'     , array($defaultUserGroup));
      
      							//If autoregister is set let's register the user
						$autoregister = isset($options['autoregister']) ? $options['autoregister'] :  $config->get('autoregister', 1).'<br>';
						if ($autoregister) {
						$data=$instance->save();
						 // $data=1;
						  if (!$data) {
						    $instance->getError(); 
							  return JError::raiseWarning('SOME_ERROR_CODE', $instance->getError());
						  }
						}
						else {
						  // No existing user and autoregister off, this is a temporary user.
						  $instance->set('tmp_user', true);
						}
						  
					$user =& JFactory::getUser($username);
					
				  	$user_id = $user->get('id') ;
					return $user_id ;
					//return true;
				} 

/*function categorylists()
{
	$db	=& JFactory::getDBO();	
	$db->setQuery("SELECT * FROM #__barter_category WHERE published = 1 AND parent_id = 0 order by id");
	$rows = $db->loadObjectList();
	//topMenu();
	?>
	<div id="category_list" class="listing">
		<h2><a href="index.php?option=com_listing">Barter Exchange Directory</a></h2>
		<table width="100%" cellspacing="0" cellpadding="10px" border="0">
			<tr>
				<td>
					<?php
					$total = round(count($rows)/2);
					$i = 0;
					foreach($rows as $row)
					{
						if($i == $total)
						{
							echo "</td><td>";
						}
						global $finaltotal;
						$finaltotal = 0;
						$totalproduct = countTotalProduct($row->id);
						?>
							<a href="index.php?option=com_listing&task=browse&category_id=<?php echo $row->id; ?>"><?php echo $row->category; ?></a>(<?php echo $totalproduct; ?>)<br />
						<?php
						$i++;
					}
					?>
				</td>
			</tr>
		</table>
	</div>
}*/

}
