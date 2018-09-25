<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Monstroid2
 */

?>

	</div><!-- #content -->

<?php
if (is_page( 'about-richards-wilcox' )) 
{   
if (ICL_LANGUAGE_CODE == "fr") {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center btm_cta padding">
            <div class="container">
                <h3>Find Your nearest RW authorized dealer</h3>
                <a href="/fr/dealers/">Find A Dealer</a>
            </div>
</div>';
}elseif (ICL_LANGUAGE_CODE == "es") {
	 echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center btm_cta padding">
            <div class="container">
                <h3>ENCUENTRA TU DISTRIBUIDOR RW MAS CERCANO</h3>
                <a href="/es/dealers/">Encuentra un distribuidor</a>
            </div>
</div>';
} else {
	echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center btm_cta padding">
            <div class="container">
                <h3>Find Your nearest RW authorized dealer</h3>
                <a href="/dealers/">Find A Dealer</a>
            </div>
</div>';
}
	
}
?>

	<footer id="colophon" <?php monstroid2_footer_class() ?> role="contentinfo">
		<?php get_template_part( 'template-parts/footer/footer-area' ); ?>
		<p style="text-align: center;    padding: 22px 0 0 0;    margin: 0px;    color: #888888;"><a href="http://www.rwdoors.com/wp-content/uploads/2017/12/Statement-of-Commitment-2017.pdf" style="color: #888888;">Notice of Accessibility Compliance-I trust the site complies as it is laid out in the original SOW dated May 4, 2017.</a></p>
		<?php get_template_part( apply_filters( 'monstroid2_footer_layout_template_slug', 'template-parts/footer/layout' ), get_theme_mod( 'footer_layout_type' ) ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->
<style type="text/css">
.pcontainer {
	width: 25%;
    height:700px;
    left: auto;
    position: absolute;
    padding: 15px;
    background: #f5f5f5;
    overflow-y: scroll;
    top: 59px;
}
#map {
    height: 700px;
}
.map-wrap .panel-wrap {
    height: 710px;
}
_::-webkit-full-page-media, _:future, :root .safari_only {
   select#dealer-category{float: left;font-size: 14px; color: #939393; border-left: 1px solid #acacac;border-top: 1px solid #acacac;    border-bottom: 1px solid #acacac;border-right: 0;outline: 0;padding: 12px;  height: 44px;  box-shadow: none;border-radius: 0;  border-top-left-radius: 3px;  border-bottom-left-radius: 3px;
    width: 23%;}
}
@media screen and (min-color-index:0) 
and(-webkit-min-device-pixel-ratio:0) { @media
{
     select#dealer-category{float: left;font-size: 14px; color: #939393; border-left: 1px solid #acacac;border-top: 1px solid #acacac;    border-bottom: 1px solid #acacac;border-right: 0;outline: 0;padding: 12px;  height: 44px;  box-shadow: none;border-radius: 0;  border-top-left-radius: 3px;  border-bottom-left-radius: 3px;
    width: 23%;}
  }
}}

</style>	
	
	<script>
                var tmp_distance_array=[];
                
             
	function initMap() {

			  var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 2,
				center: {
				  lat: 42.0945711,
				  lng: -153.2160421
				}
			  });
			  
			  var input = document.getElementById('places-input');
			  var infoWin = new google.maps.InfoWindow();
			  var markers = locations.map(function(location, i) {
				var marker = new google.maps.Marker({
				  position: location,
				  icon: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png'
				});
				google.maps.event.addListener(marker, 'click', function(evt) {
				  infoWin.setContent(location.info);
				  infoWin.open(map, marker);
				})
				return marker;
			  });

			  var clusterStyles = [
			  {
				textColor: 'white',
				url: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png',
				height: 55,
				width: 34
			  },
			];
			
			var mcOptions = {
				gridSize: 55,
				styles: clusterStyles,
				maxZoom: 15
			};

			
			var markerCluster=new MarkerClusterer(map, markers, mcOptions);
			
			var autocomplete = new google.maps.places.Autocomplete(input);
			autocomplete.bindTo('bounds', map);
			
			google.maps.event.addListener(autocomplete, 'place_changed', function () {
                        var thisplace = autocomplete.getPlace();
                        if (thisplace.geometry.location !== null) {
				var string=String(thisplace.geometry.location);
				str = string.replace(/\(|\)/g,'')
				var array = str.split(',');
                                custom_search_map(parseFloat(array[0]),parseFloat(array[1]));
                            }
			});
			
			  
			  
			  

			}
			var cust_locations=[];
			function custom_search_map(cus_lat,cus_lng) {

			  var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 7,
				center: {
				  lat: cus_lat,
				  lng: cus_lng
				}
			  });
				
				
			  var infoWin = new google.maps.InfoWindow();
			  var markers = locations.map(function(location, i) {
				var marker = new google.maps.Marker({
				  position: location,
				  icon: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png'
				});
				
				google.maps.event.addListener(marker, 'click', function(evt) {
				  infoWin.setContent(location.info);
				  infoWin.open(map, marker);
				})
				return marker;
			  });
			  
			    
            
                          map.setTilt(45);
			    
			 var clusterStyles = [
			  {
				textColor: 'white',
				url: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png',
				height: 55,
				width: 34
			  },
			];
			
			var mcOptions = {
				gridSize: 55,
				styles: clusterStyles,
				maxZoom: 15
			};

			
			var markerCluster= new MarkerClusterer(map, markers, mcOptions);
			  
			  
			  var input=document.getElementById('places-input').value;
			  
			  
			  jQuery(".panel-wrap").addClass('pcontainer');
			  jQuery(".panel-wrap").attr('id','side_bar');
			  jQuery(".panel-wrap").css('display','block');
                           
                          var tmp_all_location_details=[];
                          var tmp_all_location_details2=[];
                          var counter=0;
                          for (var i=0; i<markers.length; i++){
                                if( map.getBounds().contains(markers[i].getPosition()) ){
                                    var p1 = new google.maps.LatLng(cus_lat, cus_lng);
                                    var p2 = new google.maps.LatLng(markers[i].getPosition().lat(), markers[i].getPosition().lng());
                                    var tt=(google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
                                    tmp_all_location_details.push(tt);
                                    //tmp_all_location_details2[tt]=markers[i].getPosition().lat()+','+markers[i].getPosition().lng();
                                    tmp_all_location_details2[tt]=get_address_from_lat_and_long(markers[i].getPosition().lat(),markers[i].getPosition().lng());                                    
                                    counter++;
                                }
                            } 
                            
                        
                        tmp_all_location_details.sort(function(a,b) { return a - b;});
                        var new_location_array=[];
						var new_keys_array=[]
                        jQuery("#side_bar").html(' ');
                        for (var key in tmp_all_location_details) {
                            var key = tmp_all_location_details[key];
                            new_location_array[key] =  tmp_all_location_details2[key];  
							new_keys_array.push(key);	
                        }
                        
                        var new_counter=0;
                        for (var key in new_location_array) {
                            // check if the property/key is defined in the object itself, not in parent
                            if (new_location_array.hasOwnProperty(key)) { 
                                jQuery("#side_bar").append(new_location_array[key]);

								new_counter++;
                            }
                        }
						
						jQuery('.distancetolocation').each(function(i, obj) {
							jQuery(this).html(new_keys_array[i]+" km");
						});

                         
                         
                        google.maps.event.addListener(map, 'dragend', function() { 
                            for (var i=0; i<markers.length; i++){
                                if( map.getBounds().contains(markers[i].getPosition()) ){
                                    console.log(markers[i].getPosition().lat()+","+markers[i].getPosition().lng());
                                }
                            }
                        } );
                        
                        
		}
                
                function get_address_from_lat_and_long(lat1,lng1){
                    var final_address;
                    
                    for(var abc=0;abc<locations.length;abc++){
                        if(locations[abc]['lat']==lat1 && locations[abc]['lng']==lng1){
                            final_address=locations[abc]['locationdetails'];                           
                        }
                    }
                    
                    return final_address;
                }
                               					
                
			
			function geocodeAddress(geocoder, resultsMap, address) {
			
			geocoder.geocode({'address': address}, function(results, status) {                      
			  if (status === 'OK') { 
				
				 var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 10,
					center: {
					  lat: results[0].geometry.location.lat(),
					  lng: results[0].geometry.location.lng()
					}
				  });
					
				  
				  var infoWin = new google.maps.InfoWindow();
				  var markers = locations.map(function(location, i) {
					var marker = new google.maps.Marker({
					  position: location,
					  icon: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png'
					});
					
					google.maps.event.addListener(marker, 'click', function(evt) {
					  infoWin.setContent(location.info);
					  infoWin.open(map, marker);
					})
					return marker;
				  });
				  
					
				
				
					
				 var clusterStyles = [
				  {
					textColor: 'white',
					url: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png',
					height: 55,
					width: 34
				  },
				];
				
				var mcOptions = {
					gridSize: 55,
					styles: clusterStyles,
					maxZoom: 15
				};

				
				var markerCluster= new MarkerClusterer(map, markers, mcOptions);

				jQuery("#side_bar").html(' ');
				
                                
				jQuery(".panel-wrap").addClass('pcontainer');
                                jQuery(".panel-wrap").attr('id','side_bar');
                                jQuery(".panel-wrap").css('display','block');

                                var tmp_all_location_details=[];
                                var tmp_all_location_details2=[];
                                var counter=0;
                                for (var i=0; i<markers.length; i++){
                                      if( map.getBounds().contains(markers[i].getPosition()) ){
                                          var p1 = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                                          var p2 = new google.maps.LatLng(markers[i].getPosition().lat(), markers[i].getPosition().lng());
                                          var tt=(google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
                                          tmp_all_location_details.push(tt);
                                          tmp_all_location_details2[tt]=get_address_from_lat_and_long(markers[i].getPosition().lat(),markers[i].getPosition().lng());                                    
                                          counter++;
                                      }
                                  } 
                                  
                                  
                                tmp_all_location_details.sort(function(a,b) { return a - b;});
                                var new_location_array=[];
                                                        var new_keys_array=[]
                                jQuery("#side_bar").html(' ');
                                for (var key in tmp_all_location_details) {
                                    var key = tmp_all_location_details[key];
                                    new_location_array[key] =  tmp_all_location_details2[key];  
                                                                new_keys_array.push(key);	
                                }
                                
                                var new_counter=0;
                        for (var key in new_location_array) {
                            // check if the property/key is defined in the object itself, not in parent
                            if (new_location_array.hasOwnProperty(key)) { 
                                jQuery("#side_bar").append(new_location_array[key]);
							
								new_counter++;
                            }
                        }
						
						jQuery('.distancetolocation').each(function(i, obj) {
							jQuery(this).html(new_keys_array[i]+" km");
						});
                                				
				
			  } 
			});
		  }
                  
                  
                  function codeAddress_for_input(address) {
                    
                    var tmp_lat;
                    var tmp_lng;
                    var geocoder = new google.maps.Geocoder;
                    
                    geocoder.geocode( { 'address': address}, function(results, status) {
                      if (status == google.maps.GeocoderStatus.OK) {
                        tmp_lat=results[0].geometry.location.lat();
                        tmp_lng=results[0].geometry.location.lng();
                       
                      }
                    });
                                      
                                        
                    
                  }
                  
                 
                
                  
		
                  

			jQuery(".btn-find-location").click(function(){				
                            jQuery.getJSON("https://api.ipify.org/?format=json", function(e) {
                                jQuery.getJSON("https://ipapi.co/"+e.ip+"/json/ ", function (data) {                                
 
                                    custom_search_map(data.latitude,data.longitude);
                                });
                            });                                                                                                              
			});
                                           
			
			jQuery('#places-input').bind("enterKey",function(e){
				
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 10,
					center: {
					  lat: 56.130366,
					  lng: -106.346771
					}
				  });
				  
				var geocoder = new google.maps.Geocoder;
				
				var input=document.getElementById('places-input').value;                                
				geocodeAddress(geocoder, map, input);
				
			});
			jQuery('#places-input').keyup(function(e){
                            if(e.keyCode == 13)
                            {
                              jQuery(this).trigger("enterKey");                              
                            }
			});
			

			var locations = [
			<?php 
				query_posts(array("post_type"=>"dealers","posts_per_page"=>-1));
				$all_map_details=array();
				while(have_posts()){
					the_post();
                                        $temp_11=get_post_meta(get_the_ID(), 'dealer_location',true);
					$all_map_details[]=array('details'=>get_post_meta(get_the_ID(), 'dealer_location',true),'dealer_name'=>get_the_title(),"link"=>get_permalink(get_the_ID()));
				}
				
				
				for($i=0;$i<sizeof($all_map_details);$i++){                            
                                    $temp_add1 = preg_replace("/'/", "\&#39;", $all_map_details[$i]['details']['address']);
			?>	
				{
				  lat: <?php echo $all_map_details[$i]['details']['lat'];?>,
				  lng: <?php echo $all_map_details[$i]['details']['lng'];?>,
				  info: '<h3 style="margin:0 !important;"><?php echo $all_map_details[$i]['dealer_name'];?></h3><address id="customaddresstemp" style="display:none;"><?php echo $all_map_details[$i]['dealer_address'];?></address><a href="<?php echo $all_map_details[$i]['link'];?>">View Dealer</a>',
                                  dealersaddress: '<?php echo $temp_add1;?>',
                                  locationdetails: '<h3 style="margin:0 !important;"><?php echo $all_map_details[$i]['dealer_name'];?></h3><address style="margin:0;"><?php echo $temp_add1;?></address><span class="distancetolocation" style="display:block;margin:5px 0px 0px 0px;color:red;font-size:18px;"></span><a style="display:block;margin-bottom:20px;line-height:1;" href="<?php echo $all_map_details[$i]['link'];?>">View Dealer</a>'
				}, 
				<?php }?>
			];
     
                        function compare_lat_values(lat_tmp_v1){
                            var stag;
                            for(var abc=0;abc<locations.length;abc++){
                                if(lat_tmp_v1==locations[abc]['lat']){
                                    stag=locations[abc]['info'];
                                }
                            }
                            
                            return stag;
                        }
                        
                        function compare_lat_values_for_address(lat_tmp_v2){
                            var stag;
                            for(var abc=0;abc<locations.length;abc++){
                                if(lat_tmp_v2==locations[abc]['lat']){
                                    stag=locations[abc]['dealersaddress'];
                                }
                            }
                            
                            return stag;
                        }
                        
                        function calcDistance(loc1) {
                            var loc2=document.getElementById('places-input').value;
                            var geocoder = new google.maps.Geocoder;                            
                            
                            geocoder.geocode( { 'address': loc2}, function(results, status) {
                              if (status == google.maps.GeocoderStatus.OK) {
                                  
                                var tt_arr=[];
                                for(var i=0;i<loc1.length;i++){
                                    var temp=loc1[i].split(',');
                                    var l1, l2;
                                    l1=parseFloat(temp[0]);
                                    l2=parseFloat(temp[1]);
                                    var p1 = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                                    var p2 = new google.maps.LatLng(l1, l2);
                                    var tt=(google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);                                    
                                     tt_arr.push(tt);
                                   
                                }

                                jQuery('.distancefromcurrentloc').each(function(i1, obj) {
                                        
                                        jQuery(this).html(tt_arr[i1]+' km');                       

                                });

                              }
                            });
                            
                        }
                        

			
			jQuery(document).ready(function(){			  
			  jQuery.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyAqCyD9KWKhbahYUl5g46LCShggVeRoLoU&libraries=places,geometry&callback=initMap",function(){
				  initMap();      
			  });                     
                          
                        });
			
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <style>
        @media only screen and (min-width: 320px) and (max-width:1024px)
{
.tm_pb_text.tm_pb_module.tm_pb_bg_layout_light.tm_pb_text_align_center.slider_over.tm_pb_text_0{display:block !important;}
}
    </style>
<?php wp_footer(); ?>

</body>
</html>
