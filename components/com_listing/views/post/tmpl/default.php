<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Error');

// Access check
//see if they can post
//or if they have one post up, see if they can post multiple
if (!JFactory::getUser()->authorise('core.manage.post', 'com_listing')) {
	//return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	return JError::raiseWarning(404, JText::_('Please upgrade your account to create a listing'));
}
//now see if they already have one listing, if so, ask them to upgrade again
$user=& JFactory::getUser();
$user_id = $user->get('id');
$db	=& JFactory::getDBO();	
//get all listing using user_id
$db->setQuery("SELECT * FROM #__barter_listing WHERE user_id = $user->id");
$listings = $db->loadObjectList();

if(count($listings) == 1){
	//echo "no listings yet";die;
  // Access check.
  if (!JFactory::getUser()->authorise('core.manage.post.multiple', 'com_listing')) {
  	//return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
  	return JError::raiseWarning(404, JText::_('Please upgrade your account to create more listings.'));
  }
}

jimport ( 'joomla.html.pane');
 JHTML::_('behavior.tooltip');
require_once( JPATH_ADMINISTRATOR . DS ."components". DS ."com_listing". DS ."helpers". DS ."listing.php");
?>
<script src="components/com_listing/script/jquery.js"></script>
<script src="components/com_listing/script/datetimepicker_css.js"></script>
<?php
 $user =& JFactory::getUser();
 $user_id=$user->get('id');
	if($user_id == 0)
	{  
	$msg = JText::_( "Please login....");
			$redirectUrl = base64_encode("index.php?option=com_listing&view=post");
			$version = new JVersion;
            $joomla = $version->getShortVersion();
            if(substr($joomla,0,3) == '1.5'){
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);
            }else{
                $link = JRoute::_("index.php?option=com_users&view=login&return=".$redirectUrl, false);    
            }
			JFactory::getApplication()->redirect($link, $msg);
	 }
	 echo ListingHelper::topMenu(); ?>	 
  <form method="post" action="index.php" name="adminForm">
  <table class="admintable">
  <tbody>
  <!--<tr>
  <td width="20%" class="key">
  <label for="message">Listing Type</label>
  </td>
  <td>
  <select name="type" id="type">
	<option value="1">Barter - Offers Only</option>
	<option value="2">Barter and Trade Credits</option>
	<option value="3">Auction</option>
	</select>
  </td>
  </tr>-->
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
  <?php /*?> <textarea class="inputbox" name="description" id="description"  ></textarea><?php */?>
  <?php  
	  //$editor =& JFactory::getEditor();
	 // echo $editor->display('description',"", '550', '400', '60', '20');  
  //$description = $row['description'];
  $editor =& JFactory::getEditor();
 echo $editor->display( 'description', "", '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;
  ?>
  </td>
  </tr>
  <!--<tr>
  <td width="20%" class="key">
  <label for="message">Website Address</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="homeurl" id="homeurl" size="40"  />
  </td>
  </tr>-->
  <?php
  $db	=& JFactory::getDBO();	
  //get all category
  $db->setQuery("SELECT * FROM #__barter_category WHERE parent_id = 0 order by id");
  $categories = $db->loadObjectList();
  //print_r( $categories);die;
  ?>

  <tr>
  <td width="20%" class="key" style="padding-top:30px;">
  <label for="message">Category</label>
  </td>
  <td style="padding:30px 0px 10px 0px;">
   <select name="category_id">
   <option value="0">Select Category</option>
  <?php
  foreach($categories as $data1){ 
  ?>
<option value="<?php echo $data1->id; ?>" ><?php echo $data1->category; ?></option>

<?php 

$data_child=ListingHelper::getDistinct('#__barter_category','*','where parent_id='.$data1->id,'loadObjectlist');

?>
<?php 
foreach($data_child as $data_child1){
?>

<option value="<?php echo $data_child1->id; ?>">
<?php 
echo   '|_'.''.$data_child1->category.'';
?></option>

<?php 
$data_childs=ListingHelper::getDistinct('#__barter_category','*','where parent_id='.$data_child1->id,'loadObjectlist');

foreach($data_childs as $data_child2){
?>
<option value="<?php echo $data_child2->id; ?>">
<?php 
echo   '|__'.''.$data_child2->category.'';
?></option>

<?php 
} 

}  


}
?>
</select>
</td>
 </tr>
 <?php /*?> <select name="category_id">
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
  </select><?php */?>
  
 
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
 <!-- <input type="checkbox" name="persistent" <?php echo ($row->persistent == 1)? 'checked="checked"' : ''; ?> value="1">Make this a Persistent Listing-->
  </td>
  </tr>
 <?php /*?> new wishlist added as on 07-04-12<?php */?>
   <tr>
  <td width="20%" class="key">
  <label for="message">Wishlist</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="wishlist" id="wishlist" size="40"  />
  </td>
  </tr>
	
	
  <tr>
  <td width="20%" class="key">
  <label for="message">Location</label>
  </td>
  <td>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en"></script>
<div id="mapDivWrapper" style="margin:0;padding:0;width:100%;">
<div id="placesDivAC" style="margin:0;padding:0px;width:100%;height:20px;">
		<input name="address"  class="inputbox" id="searchTextField" type="text" size="40"  onchange="Do_Find(); return false;">
		  <!--<button id="findAddressButton" onclick="Do_Find(); return false;">Find</button>-->
</div>

<div id="mapResultDiv" style="margin:0;padding:0px;width:100%;height:0px">
<input name="latitude" id="resultLat" type="hidden" size="20">
<input name="longitude" id="resultLng" type="hidden" size="20">
<br />
</div>

<div id="GMapsID" style="margin:0;padding:0;width:0px;height:0px;visibility:hidden; padding:0px;">
<script type="text/javascript" >//<![CDATA[
var initialLocation;
var spblocation;
var browserSupportFlag =  new Boolean();
var map;
var infowindow;
var marker;
var geocoder;
var inputPlacesAC;
function initializeMap() {
infowindow = new google.maps.InfoWindow();
geocoder = new google.maps.Geocoder();
//spblocation = new google.maps.LatLng(59.9388, 30.3158);
spblocation = new google.maps.LatLng(55.75, 37.62);
var myOptions = {
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
      panControl: true,
      zoomControl: true,
      zoomControlOptions: {
            style: google.maps.ZoomControlStyle.DEFAULT
          },
      mapTypeControl: true,
      mapTypeControlOptions: {
      mapTypeIds: [
	  google.maps.MapTypeId.ROADMAP,
	  google.maps.MapTypeId.TERRAIN,
	  google.maps.MapTypeId.SATELLITE,
	  google.maps.MapTypeId.HYBRID
	]
      },
      scaleControl: false,
      streetViewControl: false,
      rotateControl: false,
      overviewMapControl: true
  };

 map = new google.maps.Map(document.getElementById("GMapsID"), myOptions);

    initialLocation = spblocation;
    map.setCenter(initialLocation);
    marker = new google.maps.Marker({
      position: initialLocation, 
      draggable:true, 
      map: map, 
      animation: google.maps.Animation.DROP,
      title:""
    });
    google.maps.event.addListener(marker, 'drag', function(event) {
      resultLng.value = event.latLng.lng();
      resultLat.value = event.latLng.lat();
    });
    google.maps.event.addListener(map, 'click', function(event) {
      marker.setPosition(event.latLng);
      resultLng.value = event.latLng.lng();
      resultLat.value = event.latLng.lat();
    });
  /*	
      // Try W3C Geolocation method (Preferred)
      if(navigator.geolocation) {
        browserSupportFlag = true;
        navigator.geolocation.getCurrentPosition(function(position) {
          initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
    map.setCenter(initialLocation);
    marker.setPosition(initialLocation);
        }, function() {
          handleNoGeolocation(browserSupportFlag);
        });
      } else if (google.gears) {
        // Try Google Gears Geolocation
        browserSupportFlag = true;
        var geo = google.gears.factory.create('beta.geolocation');
        geo.getCurrentPosition(function(position) {
          initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
    map.setCenter(initialLocation);
    marker.setPosition(initialLocation);
        }, function() {
          handleNoGeolocation(browserSupportFlag);
        });
      } else {
        // Browser doesn't support Geolocation
        browserSupportFlag = false;
        handleNoGeolocation(browserSupportFlag);
      }
	  */
  inputPlacesAC = document.getElementById('searchTextField');
  resultLat = document.getElementById('resultLat');
  resultLng = document.getElementById('resultLng');
  var autocompletePlaces = new google.maps.places.Autocomplete(inputPlacesAC);
  autocompletePlaces.bindTo('bounds', map);
  google.maps.event.addListener(autocompletePlaces, 'place_changed', function() {
  var place = autocompletePlaces.getPlace();
  var markerPlacesACText = place.name;
  if (place.geometry.viewport) 
  {
    map.fitBounds(place.geometry.viewport);
  } 
  else 
  {
    map.setCenter(place.geometry.location);
    map.setZoom(17);
  }
  marker.setPosition(place.geometry.location);
  marker.setTitle(markerPlacesACText);
  marker.setMap(map);
  resultLng.value = place.geometry.location.lng();
  resultLat.value = place.geometry.location.lat();
  });
};
/*
function handleNoGeolocation(errorFlag) {
  if (errorFlag == true) {
    initialLocation = spblocation;
  } else {
    initialLocation = spblocation;
  }
  map.setCenter(initialLocation);
  marker.setPosition(initialLocation);
};*/

function Do_Find() {  geocoder.geocode( { 'address': inputPlacesAC.value}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK) {
    var latlngFind = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
    map.setCenter(latlngFind);
    map.setZoom(17);
  marker.setPosition(latlngFind);
  marker.setTitle(inputPlacesAC.value);
  marker.setMap(map);
      resultLng.value = latlngFind.lng();
      resultLat.value = latlngFind.lat();
  }
  else
  {
    alert("Geocode was not successful for the following reason: " + status + "\n" + "for address: "+inputPlacesAC.value);
  }
});
};
window.onload = initializeMap;
//]]>
</script>

</div>
</div>	


  </td>
  </tr>	
   <!--<tr>
  <td width="20%" class="key">
  <label for="message">Listing Ends:</label>
  </td>
  <td>
  <input class="inputbox" type="text" name="end_date" id="end_date" size="40"  />
	<b onclick="javascript:NewCssCal('end_date', 'ddMMyyyy', 'dropdown', 'true', '12', 'false', 'future')" style="cursor:pointer">date picker</b>
  </td>
  </tr>-->

	<tr>
  <td width="20%" class="key">
  <label for="message">Listing Ends:</label>
  </td>
  <td>
	
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<style>
.ui-datepicker-trigger {
position:relative;
top:3px;
height:16px;
}
</style>

<script>
$(function() {
//http://jqueryui.com/datepicker/
//$( ".selector" ).datepicker({ minDate: new Date(2013, 1 - 1, 1) });
$( "#datepicker" ).datepicker({ minDate: new Date("<?php $today = date("Y, m, d"); echo $today; ?>") });

});

$.datepicker.setDefaults({
showOn: "both",
buttonImageOnly: true,
buttonImage: "http://www.barter-sites.com/joomla264/components/com_listing/views/post/tmpl/calendar.jpg",
buttonText: "Calendar",
});

</script>

<input name="end_date" type="text" id="datepicker" />

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
 
  
  </form>
