<footer class="f-footer footer-dealers" role="contentinfo">
			<div class="container-fluid">
				<div id="inner-footer" class="clearfix">
					<div class="f-bottom">
						<div class="if-bottom">
							<div class="l-foot">
								<?php echo do_shortcode( '[widget id="text-32"]' ); ?>
							</div>
						</div>

						<div id="m-foot">
							<nav class="clearfix">
								<?php wp_nav_menu( array('menu' => 'Dealers Footer Menu', 'menu_id' => 'menu-footer-menu' )); ?>
							</nav>

							<p class="t-en c-right">Copyright © 2015 Richards-Wilcox Canada All Rights Reserved.</p>
						</div>
					</div>
				</div> <!-- end #inner-footer -->
			</div> <!-- end #container -->
		</footer> <!-- end footer -->
				
		<!--[if lt IE 7 ]>
  			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
	<!--	<script>
		   var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        alert(navigator.geolocation.getCurrentPosition(showPosition));
    } else {
        alert( "Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
    return "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude; 
}
		</script> -->
		<?php wp_footer(); // js scripts are inserted using this function ?>

	</body>
</html>