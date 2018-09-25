function initializePhoneClickHandler(ancestorNode) {
	if (__gaTracker && ancestorNode) {
		var phoneNumberEl = ancestorNode.querySelector('.dealer-phone-number');
		if (phoneNumberEl) {
			phoneNumberEl.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				var dealerName = phoneNumberEl.getAttribute('data-dealerName');
				var dealerPhone = phoneNumberEl.getAttribute('data-dealerPhone');
				if (dealerName && dealerPhone) {
					__gaTracker('send', 'event', 'Contact Info - Phone Number', 'View', dealerPhone + ' (' + dealerName + ')');
					var parent = phoneNumberEl.parentNode;
					phoneNumberEl.remove();
					parent.appendChild(document.createTextNode(dealerPhone));
				}
				return false;
			});
		}
	}
}

var search_place='', search_cat='';

var cus_lat;
var cus_lng;

jQuery(function($){
	
	/* Google Map */
	
	google.maps.event.addDomListener(window, 'load', init);
	var map;

	function init() {
		var mapOptions = {
			center: new google.maps.LatLng(43.3186089,-79.95454789999997),
			zoom: 13,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.DEFAULT,
			},
			disableDoubleClickZoom: true,
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
			},
			scaleControl: true,
			scrollwheel: true,
			panControl: true,
			streetViewControl: true,
			draggable : true,
			overviewMapControl: true,
			overviewMapControlOptions: {
				opened: false,
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP,
		}
	  
		var mapElement = document.getElementById('map');
		map = new google.maps.Map(mapElement, mapOptions);
	  
		var infowindow = new google.maps.InfoWindow();
		var input = document.getElementById('places-input');
		var autocomplete = new google.maps.places.Autocomplete(input);
		
		autocomplete.bindTo('bounds', map);
		
		autocomplete.addListener('place_changed', function() {
			infowindow.close();
			marker.setVisible(false);
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				// User entered the name of a Place that was not suggested and
				// pressed the Enter key, or the Place Details request failed.
				//window.alert("No details available for input: '" + place.name + "'");
				return;
			}

			// If the place has a geometry, then present it on a map.
			if (place.geometry.viewport) {
				$( ".btn-search" ).trigger( "click" );
				map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
				map.setZoom(12);
			}
		});
	 
		google.maps.event.addListener(map, 'zoom_changed', function() {
			zoomChangeBoundsListener = 
			google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
				if (this.getZoom() > 16 && this.initialZoom == true) {
					// Change max/min zoom here
					this.setZoom(12);
					this.initialZoom = false;
				}
			});
		});
		
		map.initialZoom = true;
	  
		var markers = [];

		var clusterStyles = [{
			textColor: 'white',
			url: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png',
			height: 53,
			width: 34
		}];
	  
		var markerBounds = new google.maps.LatLngBounds();
		
		for (i = 0; i < locations.length; i++) {
			marker = new google.maps.Marker({
				icon: 'http://www.rwdoors.com/wp-content/themes/monstroid2-child/pin.png',
				position: new google.maps.LatLng(locations[i][2], locations[i][3]),
				map: map,
				title: locations[i][0],
				desc: locations[i][1],
			});

			// Showing the marker
			bindInfoWindow(marker, map, locations[i][0], locations[i][1], locations[i][4]);

			markers.push(marker);
		
			markerBounds.extend(marker.position);
			map.fitBounds(markerBounds);
		}
	  
		var mcOptions = {
			gridSize: 50,
			styles: clusterStyles,
			maxZoom: 15
		};
		
		var markerCluster = new MarkerClusterer(map, markers, mcOptions);

		// Center the marker. If only one location given then 
		if (typeof mapCenter != "undefined" || locations.length == 1) {
			if(locations.length == 1 && typeof mapCenter == "undefined");
			
			var mapCenter = {lat: locations[0][2], lng: locations[0][3]};

			map.setCenter(new google.maps.LatLng(mapCenter.lat, mapCenter.lng));
		}

		var allOpenedWindows = [];

		function closeWindows() {
			allOpenedWindows.forEach(function(el, index) {
				el.close();
			});
		}

		function bindInfoWindow(marker, map, title, desc, web) {
			var link = web;
			var formLink = "<a href='" + link +"'>"+ "View Dealer" +"</a>";

			google.maps.event.addListener(marker, 'click', function() {
				var html= "<div class='info-box'><h4>"+title+"</h4><p>"+desc+"</p>" + formLink + "</div>";
				iw = new google.maps.InfoWindow({content:html});
				// Closing all popups
				closeWindows();
				allOpenedWindows.push(iw);
				iw.open(map,marker);
			});
		}
	}
	
	/* Map Functions */
	
	// Constants
	var max_dist1 = 40.0 * 1000; // 40km
	var max_dist2 = 20.0 * 1000; // 20km
	var dist_step = 100.0 * 1000; // Radius increase step 100km
	var grand_max_dist = 2400.0 * 1000; // Maximum radius 2500km

	// Variables
	var all_locations = locations.slice();
	var cur_pos = false; // Array [0, 1] with latitude and longitude or false

	// Initialization

	init_search_button();
	init_find_location_btn();

	// Implementation

	function init_find_location_btn() {
		$('.btn-find-location').on('click', function(ev){
			ev.preventDefault();
			init_geolocation();
			
			$.ajax({
				url: 'http://ip-api.com/json',
				type: "get",
				async:false,
				success:function(res){
					//console.log(res);
					cus_lat=res.lat;
					cus_lng=res.lon;
					
				}
			});
			
			//init_geolocation(cus_lat,cus_lng);
		});
	}

	function simplify_str(s) {
		return $.trim(s.replace(/[^a-zA-Z0-9]/g, ' ').replace(/ +/g, ' ')).toLowerCase();
	}

	function good_for_search(loc, search_place, search_cat, dist) {
		var search_place = simplify_str(search_place);
		loc.dist = get_distance(loc);
		return (!search_cat || (loc[5].indexOf(search_cat) != -1)) &&
			(!search_place || (loc.dist < dist));
	}

	function init_search_button() {
		var geocoder = new google.maps.Geocoder();
		$('.btn-search').on('click', function(ev){
			ev.preventDefault();
			search_place = $('#places-input').val();
			if (search_place == $('#places-input').attr('placeholder')) search_place = '';
			search_cat = $('#dealer-category').val();
			if (search_place) {
				geocoder.geocode({'address': search_place}, geo_results);
			} else {
				geo_results(false, 'OK');
			}
		});
		
		$('#places-input').keypress(function(e){
			if(e.which == 13){//Enter key pressed
				$('.btn-search').click();//Trigger search button click event
			}
		});
	}
	
	function sort_locations() {
		locations.sort(function(a, b){
		return a.dist - b.dist;
		});
	};
	
	function get_max_dist(search_place) {
		var s = $.trim(search_place.toLowerCase());
		var m = [
			'Newmarket',
			'Newmarket, ON, Canada',
			'Stouffville',
			'Stouffville, ON, Canada',
			'Durham',
			'Durham, ON, Canada'
		];
		var dist, i = 0;
		while ((i < m.length) && (m[i].toLowerCase() != s)) i++;
		if (i < m.length) dist = max_dist2;
		else dist = max_dist1;
		return dist;
	}

	function geo_results(results, status) {
		if (status === 'OK') {
			if (results !== false) {
				cur_pos = [results[0].geometry.location.lat(),
					results[0].geometry.location.lng()];
			}
			
			locations = [];
			var dist = get_max_dist(search_place);
			do {
				for (var i = 0; i < all_locations.length; i++) {
					var loc = all_locations[i];
					if (good_for_search(loc, search_place, search_cat, dist)) {
						locations.push(loc);
					}
				}
				dist += dist_step;
			} while (!locations.length && (dist < grand_max_dist));
			sort_locations();
			init();
			show_search_results();
		} else {
			console.log('Geocode was not successful for the following reason: ' + status);
		}
	}

	function show_search_results() {
		$('.panel-wrap').show();

		// Count
		var n = locations.length, s = n + ' dealer';
		if ((n % 10 != 1) || (n % 100 == 11)) s += 's';
		$('#search-count').text(s);

		// Items
		var $wrap = $('#search-results');
		var $item0 = $('#search-results-store .search-result').first();
		$wrap.empty();
		for (var i = 0; i < locations.length; i++) {
			var loc = locations[i];
			var $item = $item0.clone();
			$item.attr('href', loc[4]);
			$item.find('.name').html(loc[0]);
			$item.find('.address').html(loc[6]);

			// $item.find('.phone').html(loc[7]);
			$item.find('.phone').html('<span class="dealer-phone-number" data-dealerName="' + loc[0].replace(/'/g, '&#39;') + '" data-dealerPhone="' + loc[7] + '">CLICK TO CALL</span>');
			var ancestorNode = $item.get(0);
			if (ancestorNode) {
				initializePhoneClickHandler(ancestorNode);
			}

			$item.find('.distance').text(get_distance_km(loc));
			$item.appendTo($wrap);
		}
	}

	function get_distance_km(loc) {
		var s, d = get_distance(loc);
		
		if (d === false) {
			s = '? km';
		} else {
			d /= 1000;
			s = Math.round(d * 100) / 100 + ' km';
		}
		return s;
	}

	function get_distance(loc) {
		var d = false;
		if (cur_pos !== false) {
			var rad = function(x){return x * Math.PI / 180;};
			var x1 = parseFloat(loc[2]), y1 = parseFloat(loc[3]);
			var x2 = parseFloat(cur_pos[0]), y2 = parseFloat(cur_pos[1]);
			var R = 6378137; // Earth’s mean radius in meter
			var dLat = rad(x1 - x2);
			var dLong = rad(y1 - y2);
			var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos(rad(x1)) * Math.cos(rad(x2)) *
				Math.sin(dLong / 2) * Math.sin(dLong / 2);
			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			var d = R * c;
		}
		return d;
	}

	function got_geolocation() {
		search_place = 'CUR';
		search_cat = '';
		geo_results(false, 'OK');
		map.setCenter({lat: cur_pos[0], lng: cur_pos[1]});
		map.setZoom(9);
	}

	function init_geolocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				browserGeolocationSuccess,
				browserGeolocationFail,
				{maximumAge: 50000, timeout: 20000, enableHighAccuracy: true}
			);
		} else {
			cur_pos = false;
		}
	}

	var apiGeolocationSuccess = function(position) {
		cur_pos = [position.coords.latitude, position.coords.longitude];
		got_geolocation();
	};

	var tryAPIGeolocation = function() {
		/*jQuery.post( "https://www.googleapis.com/geolocation/v3/geolocate?key=AIzaSyCF_SYfQQj74oABUrRbmynzEeCesc5rKto", function(success) {
			// apiGeolocationSuccess({coords: {latitude: success.location.lat, longitude: success.location.lng}});
		})
		.fail(function(err) {
			alert("API Geolocation error! \n\n"+err);
		});*/
		apiGeolocationSuccess({coords: {latitude: cus_lat, longitude: cus_lng}});
	};

	var browserGeolocationSuccess = function(position) {
		cur_pos = [position.coords.latitude, position.coords.longitude];
		got_geolocation();
	};

	var browserGeolocationFail = function(error) {
		switch (error.code) {
			case error.TIMEOUT:
				alert("Browser geolocation error !\n\nTimeout.");
			break;
			case error.PERMISSION_DENIED:
			if(error.message.indexOf("Only secure origins are allowed") == 0) {
				tryAPIGeolocation();
			}
			break;
			case error.POSITION_UNAVAILABLE:
				alert("Browser geolocation error !\n\nPosition unavailable.");
			break;
		}
	};
});