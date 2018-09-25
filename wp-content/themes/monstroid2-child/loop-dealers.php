<?php
	$args = array(
		'post_type' => 'dealers',
		'posts_per_page'=> -1,
		'order'=> 'DESC',
	);

	$loop = new WP_Query( $args );
?>

<?php $array = "["; ?>

<?php if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
	<?php
		$title = get_the_title();
		$title = addslashes($title);
		$location = get_field('dealer_location');
		$location_address = $location['address'];
		$location_address = addslashes($location_address);
		$location_lat = $location['lat'];
		$location_lng = $location['lng'];
		$desc = get_field('dealer_description');
		$category = get_field('dealer_category');
		$category_separated = implode(",", $category);
		$link = get_permalink();
		
		if( get_field('dealer_free_phone') ) {
			$phone = get_field('dealer_free_phone');
		} else {
			$phone = get_field('dealer_phone');
		}
			
		$array .= "['$title','$desc','$location_lat','$location_lng','$link', '$category_separated','$location_address','$phone']";
		
		if (($loop->current_post +1) != ($loop->post_count)) {
			$array .= ',';
		}
	?>

<?php endwhile; ?>

<?php endif; ?>

<?php $array .= "]"; ?>

<?php wp_reset_query(); ?>

<script type="text/javascript">
	var locations = <?php echo $array; ?>;
</script>

<div class="map-wrap">
	<div class="search-wrap">
		<h2>Find a Richards-Wilcox Authorized Dealer</h2>
  
		<!--<input id="places-input" class="controls" type="text" placeholder="Enter your city or Zip/Postal Code">-->
		
		<input id="places-input" class="controls" type="text" placeholder="Enter your city or Zip/Postal Code">
		
          
		<span class="btn-find-location"></span>
    
		<select id="dealer-category">
			<option value="residential">Residential</option>
			<option value="commercial">Commercial</option>
		</select> 
    
		<span id="btn-search" class="btn-search">Find Dealers</span>
	</div>

	<div id="map" class="map"></div>
	
	<div class="panel-wrap">
		<div class="panel-top">
			There are <span id="search-count"></span> near your location
		</div>
	
		<div id="search-results">
			<!-- Search results will be put in here after cloning them from #search-results-store -->
		</div>

		<div id="search-results-store" style="display:none">
			<a class="search-result" href="#">
				<div class="marker">
					<span class="marker-label"></span>
					<span class="distance"></span>
				</div>
        
				<div class="details">
					<h3 class="name"></h3>
					<p class="address"></p>
					<p class="phone"></p>
				</div>
			</a>
		</div>
    </div>
</div>