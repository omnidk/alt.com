<?php
defined('_JEXEC') or die ('restrcted access');
$link  = 'index.php?option=com_listing&view=account';
//$link1 = 'index.php?option='.JC_COMPONENT_NAME.'&view='.JC_JOMCOUPON_PLANS.'';
$link2 = 'index.php?option=com_listing&view=category';

?>



<style>
.controltable

{

background-color:#F7F8F9;
border:1px solid #D5D5D5;
padding:5px;
text-align:center;
}

.controltable1 a
{
height:97px;
text-decoration:none;
vertical-align:middle;
width:108px;
text-align:center;
border:1px solid #F0F0F0;
color:#666666;
display:block;

}

.controltable1 a:hover {
background-color:#EFEFEF ;
text-decoration:none;
border:1px solid #D5D5D5;

}
.table:hover{
text-decoration:none;
}
.controltable:link{
color:red ;
}

.controllink :hover{
text-decoration:none;
}

.ontab{
background-color:#FFAE00;
border:1px solid #CCCCCC;
color:#FFFFFF;
cursor:pointer;
font-size:12px;
font-weight:bold;
text-align:center;
width:14%;
}

.offtab{
background-color:#E5E5E5;
border:1px solid #CCCCCC;
cursor:pointer;
font-size:12px;
font-weight:normal;
text-align:center;
width:14%;
}

.imagesize{ 
width:48px;
margin-top:5px;
}

</style>







<link rel="shortcut icon" href="<?php echo JCLogoPath.'/favicon.png';?>">


<div style=" width:100%; text-align:center;">



		 <div style="float:left; width:100%;">	



			<div style="float:left;">



				



				<img src="<?php echo JCLogoPath.'/jc_cpanel48x48.png';?>" 



				height="48" width="48" title="Control Panel"/>



			</div>



			<div style="float:left;padding:10px; font-size:20px; font-weight:800; color:#808080 ;"> <?php echo 'Control Panel'; ?> </div>



		</div>	



        



		<div style="float:left; border:1px solid #F0F0F0; width:auto;">



		<table align="left" style="padding:5px 10px;" cellpadding="5" cellspacing="5">



			<tr>


				<td class="controltable1";>



					<a href="<?php echo $link?>" title="Create/Edit Category" class="table">



				    <img src="<?php echo JCLogoPath.'/category48x48.png' ?>" align="middle"



					title="Create/Edit Category" class="imagesize"/>



					<br/><?php echo "Account";?> 



					</a> 



				</td>
                
                <?php /*?> <td class="controltable1";>



					<a href="<?php echo $link1 ?>" title="Plans" class="table">



				    <img src="<?php echo JCLogoPath.'/plan48x48.png' ?>" align="middle"



					title="Plans" class="imagesize"/>



					<br/><?php echo "Plans";?> 



					</a> 



				</td> <?php */?>
                 
                
                 <td class="controltable1";>



					<a href="<?php echo $link2 ?>" title="Create Coupon" class="table">



				    <img src="<?php echo JCLogoPath.'/coupon48x48.png' ?>" align="middle"



					title="Create Coupon" class="imagesize"/>



					<br/><?php echo "Category";?> 



					</a> 



				</td> 
                 
                <?php /*?> <td class="controltable1";>



					<a href="<?php echo $link3 ?>" title="Free Coupon Code" class="table">



				    <img src="<?php echo JCLogoPath.'/freecoupon48x48.png' ?>" align="middle"



					title="Free Coupon Code" class="imagesize"/>



					<br/><?php echo "Free Coupon Code";?> 



					</a> 



				</td> 
                 <?php */?>

             </tr>



		</table>



		</div>



	</div>


<div style="float:right; width:40%; text-align:center; text-decoration:none;" class="controllink"> 



				           <a href="http://www.widejoomla.com">

						   <img src="<?php echo JCLogoPath.'/widevisionlogo.png' ?>" />

						  </a>



			</div> 