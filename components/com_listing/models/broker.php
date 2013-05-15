<?php

defined ('_JEXEC') or die('Ristrict Acces');

jimport('joomla.application.component.model');
require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_listing'.DS.'helpers'.DS.'listing.php');
require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'broker.php');
require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'useradd.php');
require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_listing'.DS.'tables'.DS.'user.php');

class ListingModelBroker extends JModel

{
	var $_data = null;
    function store()
	{ 
	$db 	  		= & JFactory::getDBO();
	//$amount  = JRequest::getVar('amount'); $_REQUEST['amount'];
	$senderName 		= JRequest::getVar('from');
	$receiverName 		=JRequest::getVar('to');
	$comments 			= JRequest::getVar('comment');
			
	//$commission = ($amount*$account_detail['comission_percent'])/100;
	
	$senderID = ListingHelper::getUserId($senderName);
	//print_r($senderID);die;
	if($senderID == '')
	{ echo "Sender not found.";
	}
	
	$receiverID =  ListingHelper::getUserId($receiverName);	
	
	if($receiverID == '')
	{ echo "Receiver not found.";
	}
		
	$recieverblock = ListingHelper::detail('#__barter_users_history','','status','user_id',$receiverID ,'','loadresult');
	if($recieverblock == '1'){
		$this->setError('Sorry! Right now '.$receiverName.' is blocked.');
		return false;
	}
	
	$recieverblock = ListingHelper::detail('#__barter_users_history','','status','user_id',$senderID ,'','loadresult');
	if($recieverblock == '1'){
		$this->setError('Sorry! Right now '.$receiverName.' is blocked.');
		return false;
	}
	

 
	

	//SELECT * FROM #__barter_account limit 0,1
	$recievermail = ListingHelper::detail('#__users','','email','id',$receiverID ,'','loadresult');
	$sendermail = ListingHelper::detail('#__users','','email','id',$senderID ,'','loadresult');
	
	$admin_from_mail = ListingHelper::detail('#__barter_account','','from_email','','' ,'','loadresult');
	$admin_from_name = ListingHelper::detail('#__barter_account','','from_name','','' ,'','loadresult');
	
	//echo $admin_from_mail;
	//die('LOOK@ME');
	
	$mailer =& JFactory::getMailer();
	$config =& JFactory::getConfig();
	
	$sender = array( 
    	$config->setValue( $admin_from_mail ),
    	$config->getValue( $admin_from_name ) 
    );
    $mailer->setSender($sender);
	
	$row =& $this->getTable('broker');
	$data = JRequest::get( 'post' );
	$row->sender_id=$senderID;
	$row->receiver_id=$receiverID;
	//print_r($_POST);die;
	
	$array = JRequest::getVar('cid',  0, '', 'array');

	$id = (int)$array[0];
	
	if($id)
		{
			$row->id= $id;
		
		}
	if (!$row->bind($data))
	{
		
		$this->setError($this->_db->getErrorMsg());
		return false;
	}
	
	
	if (!$row->check()) 
	{
		
		$this->setError($this->_db->getErrorMsg());
		return false;
	}
	// Store the  table to the database
	if (!$row->store()) 
	{
			
		 $this->setError($this->_db->getErrorMsg()); 
		return false;
	}
	
	ListingHelper:: request_email($data,$recievermail,$senderName);
	ListingHelper:: request_email($data,$sendermail,$senderName);
	return true;
		}	
		
		
		
		
		
  function store1()
	{
	$data = JRequest::get( 'post' );
	/*
	$row =& $this->getTable('useradd');
	$data = JRequest::get( 'post' );
	//print_r($data);die;
	echo $data['name']; die;
	$array = JRequest::getVar('cid',  0, '', 'array');

	$id = (int)$array[0];
	
	if($id)
		{
			$row->id= $id;
		
		}
	if (!$row->bind($data))
	{
		
		$this->setError($this->_db->getErrorMsg());
		return false;
	}
	
	
	if (!$row->check()) 
	{
		
		$this->setError($this->_db->getErrorMsg());
		return false;
	}
	// Store the  table to the database
	if (!$row->store()) 
	{
			
		 $this->setError($this->_db->getErrorMsg()); 
		return false;
	}
	
	return true;*/
	//ListingHelper::createJoomlaUser('user_id');
	
	$user=ListingHelper::createJoomlaUser($data['name'],$data['username'],$data['email'], $data['password']);
	if($user)
	{
	 return true;
	 }
	 else
	 {
	 return false;
	 }
	}
	function user_edit(){
		$data = JRequest::get( 'post' );
		var_dump($data);
		$total_balance=JRequest::getVar('total_balance');
		$line_of_credit=JRequest::getVar('line_of_credit');
		$user_email=JRequest::getVar('user_email');
		$user_status=JRequest::getVar('user_status');
		$user_id=JRequest::getVar('user_id');
		$hs_user_id=JRequest::getVar('hs_user_id');
		
		$db	=& JFactory::getDBO();
	    $db->setQuery("update #__users set email='$user_email' where id='$user_id'");
	    $db->query();
		
	    $db->setQuery("update #__barter_users_history set total_balance = '$total_balance', line_of_credit='$line_of_credit', status= '$user_status'  where id='$hs_user_id'");
	    $db->query();

	    $msg = JText::_('user updated');		
		return true;
	}	
	
	function store2()
	{
	$data = JRequest::get( 'post' );
	$u=JRequest::getVar('user_id');
	$b=JRequest::getVar('broker_id');
	$total_balance=JRequest::getVar('total_balance');
	$line_of_credit=JRequest::getVar('line_of_credit');
	
	
		 $db	=& JFactory::getDBO();
	     $db->setQuery("SELECT `user_id` from #__barter_users_history ");
	     $db->query();
	     $userinfo = $db->loadResultArray();
	
	//$db=JFactory::getDBO();
	//$query=$db->getQuery('true');
   // $query="INSERT INTO  #__barter_users_history  SET user_id='" . $u . "', broker_id='" . $b ."',total_balance = '',line_of_credit='',total_reviews='',total_positive_reviews= 	   '',total_negative_reviews=''"; 
	//print_r($query);die;
	//print_r($data);die;
	//echo $u;
	//print_r($userinfo);
	
	foreach($userinfo as $userinfos){
		 if($userinfos==$u)
			 {			
			  $msg = JText::_('user name is already exist');
			  $app=JFactory::getApplication();
			  $app->redirect('index.php?option=com_listing&view=users',$msg);
			 }
			}
		//die;
		
		$row1 =& $this->getTable('useradd');
		$array = JRequest::getVar('cid',  0, '', 'array');
		$id = (int)$array[0];
		//print_r($userinfo);die;
		
		if($id)
			{
				$row1->id= $id;
			}
			
		if (!$row1->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
				
		if (!$row1->check()) 
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

			    
	    $db->setQuery("select default_user from  #__barter_account limit 0,1");
		$rows = $db->loadAssoc();
		$default_user = $rows['default_user'];
		$query="INSERT INTO #__barter_users_history (id ,user_id ,broker_id ,total_balance ,line_of_credit ,total_reviews ,total_positive_reviews ,total_negative_reviews ,status)"; 
		$query.="VALUES ('' ,'$u' ,'$b' ,'$total_balance' ,'$line_of_credit' ,'' ,'' ,'' ,'$default_user')";
		$db->setQuery($query);
	    $db->query();
		return true;
		}	

		
		
   
}
