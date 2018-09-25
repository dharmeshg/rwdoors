<?php get_header(); ?>

<div id="content" class="clearfix row-fluid">
	<div class="container-fluid1 dealer-top">
		<div class="float-left">
			<a class="btn-back" href="<?php bloginfo('url'); ?>/dealers/">Back to Search Results</a>
			<div class="contact-infoleft">
			<h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>
			
			<p class="authorized">Authorized Dealer</p>
</div>
			
			<div class="contact-info">

				<?php
				$dealer_location = get_field('dealer_location');
				$dealerName = htmlentities(get_the_title(), ENT_QUOTES);
				?>

				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $dealer_location['lat']; ?>" data-lng="<?php echo $dealer_location['lng']; ?>"></div>
			
</div>
				
				<div class="address">
					<?php echo $dealer_location['address']; ?>
					
					<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); } ?>
				</div>
				
				<div class="contact">
					<?php if( get_field('dealer_free_phone') ): ?>
						<p>
							<span>Toll Free:</span>
							<?php the_field('dealer_free_phone'); ?>
						</p>
					<?php endif; ?>
					
					<?php if( get_field('dealer_phone') ): ?>
						<?php
						$dealerPhone = get_field('dealer_phone');
						?>

						<p>
							<span class="field-label">Phone:</span>
							<span class="dealer-phone-number"
								data-dealerName="<?php echo $dealerName; ?>"
								data-dealerPhone="<?php echo $dealerPhone; ?>"
							>
								<?php echo $dealerPhone; ?>
							</span>
						</p>
					<?php endif; ?>
					
					<?php if( get_field('dealer_fax') ): ?>
						<?php
						$dealerFax = get_field('dealer_fax');
						?>

						<p>
							<span class="field-label">Fax:</span>
							<span class="dealer-fax-number"
								data-dealerName="<?php echo $dealerName; ?>"
								data-dealerFax="<?php echo $dealerFax; ?>"
							>
								<?php echo $dealerFax; ?>
							</span>
						</p>
					<?php endif; ?>
					
					<?php if( get_field('dealer_website') ): ?>
						<p>
							<span>Website:</span>
							<a href="http://<?php the_field('dealer_website'); ?>" target="_blank">
								<?php the_field('dealer_website'); ?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<div class="float-right">
			<?php the_post_thumbnail('full'); ?>
		</div>
	</div>

<div class="main_form" style="display:none;">
<?php echo do_shortcode('[contact-form-7 id="4557" title="dealer form"]'); ?>
</div>
	
	<div class="dealer-slider-wrap">
		<div class="container-fluid dealer-slider" style="padding: 0px;">
			<div class="float-left">
<?php 
echo do_shortcode('[smartslider3 slider=3]');
?>


				<?php //if( get_field('dealer_email') ): ?>
					<?php //$slider_id = get_field('dealer_slider_id'); ?>
				<?php// endif; ?>
				
				<?php //if ( function_exists( 'soliloquy' ) ) { soliloquy( '1957' ); } ?>

			</div>
			
			<div class="float-right dome">
				<?php if( get_field('dealer_email') ): ?>
					<div class="form-wrap">
						<h3>Contact <?php the_title(); ?></h3>

						<?php $email = get_field('dealer_email'); ?>
				
						<?php gravity_form(14, false, false, false, array('dealer_email' => $email), false, 0, true ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="container-fluid dealer-middle">
		<div id="main" class="span8 clearfix" role="main">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
					
					<?php the_content(); ?>
				</article> <!-- end article -->
			<?php endwhile; ?>			
			
			<?php endif; ?>
		</div> <!-- end #main -->
		
		<div id="sidebar1" class="fluid-sidebar sidebar span4" role="complementary">
			<?php if( get_field('dealer_services') ): ?>
				<h3>Services</h3>
				
				<?php the_field('dealer_services'); ?>
			<?php endif; ?>
			
			<?php if( get_field('dealer_servicing_areas') ): ?>
				<h3>Servicing Areas Surrounding</h3>
				
				<?php the_field('dealer_servicing_areas'); ?>
			<?php endif; ?>
		</div>
	</div>
</div> <!-- end #content -->
</div></div>
<?php get_footer(); ?>