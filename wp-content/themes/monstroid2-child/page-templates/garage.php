<?php
/**
 * Template Name: Garage Page
 *
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Monstroid2
 */
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main_garage paddingnone text-center">
<div class="container">
<div class="gallary_title">
<!-- <p><img src="http://www.rwdoors.com/wp-content/uploads/2017/06/RW_Logo.png"></p>
<h3>Pick Your Series</h3> -->
<div class="main_gallery_home">
<?php
if (ICL_LANGUAGE_CODE == "fr") { ?>

   <?php echo do_shortcode('[rev_slider alias="residential-fr"]'); ?>
   
<?php } elseif (ICL_LANGUAGE_CODE == "es") { ?>

    <?php echo do_shortcode('[rev_slider alias="residential-es"]'); ?>
    
<?php } else {?>
    <?php echo do_shortcode('[rev_slider alias="residential"]'); ?>
<?php }
?>

</div>
<div class="for_desk slider_icon">
<img src="http://www.rwdoors.com/wp-content/uploads/2017/09/RW-symbol.png">
</div>
</div>
</div>
</div>

<?php while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/page/content', 'page' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endwhile; // End of the loop. ?>
