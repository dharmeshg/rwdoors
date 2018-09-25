<?php
/*
Template Name: Dealer Form
*/
?>

<?php get_header('dealers'); ?>

	<div id="content" class="clearfix row-fluid">
		<div class="header-banner" style="background-image: url('<?php the_field('header_image'); ?>');">
			<div class="container-fluid">
				<h1><?php the_title(); ?></h1>
				
				<span>To Our Dealer Map</span>
			
				<?php if( get_field('description') ): ?>
					<?php the_field('description'); ?>
				<?php endif; ?>
			</div>
		</div>
	
		<div id="main" class="span12 clearfix" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
			
					<?php the_content(); ?>
	
			</article> <!-- end article -->
			
			
			<?php endwhile; ?>	
			
		
			<?php endif; ?>
	
		</div> <!-- end #main -->

	</div> <!-- end #content -->

<?php get_footer(); ?>