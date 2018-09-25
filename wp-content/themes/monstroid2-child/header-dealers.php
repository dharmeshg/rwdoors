<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>
			<?php if (is_singular('dealers')) { ?>
				<?php the_title(); ?>, Garage Doors & Overhead Doors by RW Doors
			<?php } else { ?>
				RW Doors - Find Dealers <?php //wp_title( '|', true, 'right' ); ?>
			<?php } ?>
		</title>
				
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
				
		<!-- media-queries.js (fallback) -->
		<!--[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
		<![endif]-->

		<!-- html5.js -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- theme options from options panel -->
		<?php //get_wpbs_theme_options(); ?>

		<!-- typeahead plugin - if top nav search bar enabled -->
		<?php //require_once('library/typeahead.php'); ?>

<div class="sfm-rollback sfm-color1 sfm-theme-none sfm-label-visible sfm-label-metro">
    <div class="sfm-navicon-button x sf_label_default">
    <div class="sfm-navicon"></div>
    </div>
    </div>
<?php if(get_the_ID()==1933)
{?>

<?php
}?>



		<script type="text/javascript">
			function showImage(imgName, imgText) {
				var curImage = document.getElementById('currentImg');
				var textDiv = document.getElementById('rightText');			
				
				curImage.src = imgName;
				curImage.alt = imgName;
				curImage.title = imgName;
				textDiv.innerHTML = imgText;
			}
			
			function preLoadImages() {
				var tmp = new Array();
				for(var i = 0; i < attributes.length; i++) {
					tmp[i] = new Image();
					tmp[i].src = attributes[i];
				}
			}
		</script>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600italic,700,300italic,300,700italic' rel='stylesheet' type='text/css'>

<style>
#map{width:100%; float:left; height:600px;}
</style>
	</head>
	
	<body <?php body_class(); ?>>


