<?php
/**
 * Monstroid2 Child functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Monstroid2
 */
add_action( 'wp_enqueue_scripts', 'monstroid2_child_theme_enqueue_styles', 20 );

/**
 * Enqueue styles.
 */
function monstroid2_child_theme_enqueue_styles() {

	$parent_style = 'monstroid2-theme-style';

	wp_enqueue_style( $parent_style,
		get_template_directory_uri() . '/style.css',
		array( 'font-awesome', 'material-icons', 'magnific-popup', 'linear-icons', 'material-design' )
	);

	wp_enqueue_style( 'monstroid2-child-theme-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		wp_get_theme()->get( 'Version' )
	);
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Residential - Benefits Tab Content',
		'id' => 'bts',
		'description' => 'Residential - Benefits Tab Content',
		'before_widget' => '<div class="custom_side">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom_side_name">',
		'after_title' => '</h3>',
	));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Roll Over Images',
		'id' => 'i-rollover',
		'description' => 'Roll Over Images',
		'before_widget' => '<div class="custom_side">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom_side_name">',
		'after_title' => '</h3>',
	));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Commercial - Section Details Tab Content',
		'id' => 'sec-details',
		'description' => 'Commercial - Section Details Tab Content',
		'before_widget' => '<div class="custom_side">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom_side_name">',
		'after_title' => '</h3>',
	));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Overhead Doors Tab Contents',
		'id' => 'over-head',
		'description' => 'Overhead Doors Tab Contents',
		'before_widget' => '<div class="custom_side">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom_side_name">',
		'after_title' => '</h3>',
	));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Top Logo',
		'id' => 'top-logo',
		'description' => 'Top Logo',
		'before_widget' => '<div class="custom_side">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom_side_name">',
		'after_title' => '</h3>',
	));
}

function create_post_type_html5()
{
    register_post_type('dealers', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Dealers', 'html5blank'), // Rename these to suit
            'singular_name' => __('Dealer', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New Dealer', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit Dealer', 'html5blank'),
            'new_item' => __('New Dealert', 'html5blank'),
            'view' => __('View Dealer', 'html5blank'),
            'view_item' => __('View Dealer', 'html5blank'),
            'search_items' => __('Search Dealer', 'html5blank'),
            'not_found' => __('No Dealers found', 'html5blank'),
            'not_found_in_trash' => __('No Dealers found in Trash', 'html5blank')
        ),
        'public' => true,
        'publicly_queryable' => true, 
        'query_var' => true,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => false,
        'rewrite' => array('slug' => 'dealers'),
        'supports' => array(
            'title',
            'editor',
			'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true // Allows export in Tools > Export
    ));
}

add_action('init', 'create_post_type_html5');
/*
function html5blank_conditional_scripts()
{
	if (is_page_template('page-dealers.php')) {
		wp_register_script('googlemapapi', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD06VAvEKf4qiELDY5zs3J3LQuIC84nNOw&libraries=places', array('jquery'));
	//	wp_register_script('googlemapapi', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCF_SYfQQj74oABUrRbmynzEeCesc5rKto&libraries=places', array('jquery'));
		
		wp_enqueue_script('googlemapapi'); // Enqueue it!
		
		wp_register_script('markerclusterer', 'https://cdnjs.cloudflare.com/ajax/libs/js-marker-clusterer/1.0.0/markerclusterer_compiled.js', array());
		wp_enqueue_script('markerclusterer'); // Enqueue it!

		wp_register_script('googlemap', get_stylesheet_directory_uri() . '/js/googlemap.js', array('jquery'), '1.0.0');
		wp_enqueue_script('googlemap'); // Enqueue it!
	}
	
	if (is_page_template('page-dealer-form.php')) {
		wp_register_script('dealerform', get_stylesheet_directory_uri() . '/js/dealer-form.js', array('jquery'), '1.0.0');
		wp_enqueue_script('dealerform'); // Enqueue it!
	}
	
	if (is_singular('dealers') ) {
		wp_register_script('googlemapapi', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCEcnwUhJpMARyGynm__Li_C2sjMUky2XA&extension=.js', array('jquery'));
		wp_enqueue_script('googlemapapi'); // Enqueue it!

		wp_register_script('googlemapsingle', get_stylesheet_directory_uri() . '/js/googlemapsingle.js', array('jquery'), '1.0.0');
		wp_enqueue_script('googlemapsingle'); // Enqueue it!

        wp_register_script('dealer-script', get_stylesheet_directory_uri() . '/js/dealer-script.js', array('jquery'), '1.0.0');
        wp_enqueue_script('dealer-script'); // Enqueue it!
	}
}

add_action('wp_print_scripts', 'html5blank_conditional_scripts');
*/
function redirect_404_send_mail() {
    if (is_404()) {
        $mail_body = 'This page generated a 404 error: ' . $_SERVER['REQUEST_URI'];
        $mail_body .= "\nReferrer : " . $_SERVER['HTTP_REFERER'];
        //wp_mail( 'you@youremail.com', '404 page detected', $mail_body);
        wp_redirect( home_url() );
    }
}
add_action( 'template_redirect', 'redirect_404_send_mail' );
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );