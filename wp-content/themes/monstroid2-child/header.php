<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Monstroid2
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php global $post;
    $post_slug=$post->post_name;

    if($post_slug == 'landmark-intro'){
    ?>
    	<!-- Facebook Pixel Code --><script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js'); fbq('init', '880276728845395'); fbq('track', 'PageView');</script><noscript> <img height="1" width="1" src="https://www.facebook.com/tr?id=880276728845395&ev=PageView&noscript=1"/></noscript><!-- End Facebook Pixel Code -->
    <?php
    }?>

<?php wp_head(); ?>


<style>
.ppadding p{margin-bottom:6px;}
.page-template-default .well p{    margin-bottom: 0px;}
.dealers-template-default #primary{left: 0px;    max-width: 100%;    flex: 0px;}
.main_getfree_form .gform_wrapper ul li{    list-style-type: none !important;}
.page-id-7915 .site-content_wrap {margin-top:  0px !important;}
.landmarkfeat #d-tbc li img{padding-top: 30px !important;}
.page-id-6404 .page-title, .page-id-6406 .page-title{font-size: 23px;}
@media only screen and (min-width: 320px) and (max-width:1024px)
{
.tm_pb_builder #tm_builder_outer_content .tm_pb_text_0{display:block !important;}
.page-id-7615 .slider_top_content{    padding: 120px 0 0 !important;}
.authodeal img{    width: 120px;}
}
.footer-container{padding: 0px 0 25px !important;}
#overlays ul li{    white-space: inherit;}
#icl_lang_sel_widget-2{margin: 0px;    float: right;    width: 100%;    margin-top: -50px;}
.home #icl_lang_sel_widget-2 .wpml-ls-legacy-list-horizontal{    float: right;    margin-right: 88px;width: 43%;}
#icl_lang_sel_widget-2 .wpml-ls-legacy-list-horizontal{    float: right;    margin-right: 120px;    width: 37%;}
#text_icl-2{font-size: 16px;    color: #5e5e5e;    font-weight: 500;}
#icl_lang_sel_widget-2 a{background: transparent; padding: 0px;}
.none{display:none !important;}
.page .sfm-rollback.sfm-color1.sfm-theme-none.sfm-label-visible.sfm-label-metro{margin: 0 24px 0 36px !important;}
.home .sfm-rollback.sfm-color1.sfm-theme-none.sfm-label-visible.sfm-label-metro{    margin: 0 30px 0 15px !important;}
.tm_pb_section_6{display:none;}
.wp-side-menu{display:none;}
.style-3 .header-container, .style-7 .header-container{padding: 30px 0 0px;}
.slider_top_content {    padding: 120px 0 0;}
.home_h1{margin: 50px 0 50px 0 !important;}
.about_img_center { border-top: none;}
.bighead h2{text-transform: uppercase;font-size: 70px !important;}
.bighead h2 a{border-bottom: 3px solid;} 
.inner_box_rich{padding-bottom: 65px;}
.inner_box_rich_img{width: 20%;    float: left;}
.inner_box_rich_txt {    width: 80%;}
.inner_box_rich_txt h4{    color: #d72430;}
.authodeal h4{text-align: center;font-size: 25px;font-weight: 600; margin: 0 0 10px 0; line-height: 22px;   color: #d72430;}
.authodeal p{    text-align: center;    color: #222;    font-size: 15px;    line-height: 26px;    font-weight: 500;}
#none{display:none !important;}
.tm_pb_section_6{display:block !important;}
.main_gallery h3,.home_blog h3.tm-posts_title{text-transform: uppercase;}
#tm_builder_outer_content .tm_pb_slider.tm_pb_slider_full_height {    height: 80vh;}
.tm_pb_slide.tm_pb_slide_with_image.tm_pb_bg_layout_light.tm_pb_media_alignment_center.tm_pb_slide_0.tm-pb-active-slide{background-size: 100% 100% !important;}
.tm_pb_builder #tm_builder_outer_content .tm_pb_row_3{padding-bottom: 0;}
/*.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{    font-size: 19px;    padding: 20px;}
.nav-tabs>li>a{    font-size: 19px;    padding: 20px;}
#overlays ul li, #colors li{width: 10%;  height: auto;    margin: 0px 25px 8px 0;    font-size: 12px;}
#TNBodyContainer li img{    width: 100%}
.main_gallery {    border-bottom: 1px solid #000;}
.main_testimonial {    border-top: 1px solid #000;}
#colors li img, #TNBodyContainer li img{    margin-bottom: 7px !important;}

.fullwidthinfo{width:100%;float:left;padding: 10px 0 30px 0;}
#d-tbc li{    margin-bottom: 20px;}*/
#overlays ul li{    margin: 0 10px 15px 0;}
#brochures{    padding: 15px 0 0 0;}
.d-info #brochures a{    padding-top: 10px;    background-position: 100% 10px;font-size: 15px;    border: none;}
#brochures img{    margin-top: -9px !important;    padding-right: 7px !important;}
#post-7615 {        margin-top: -19px;}
#post-7615  .home_h1{    font-size: 48px;    font-weight: bold;}
.lndmrkul  ul{padding-left: 30px;    padding-top: 10px;}
.lndmrkul  ul li{    list-style: circle !important;}
.lndmrkul  ul li a{   font-weight: 500;}
.landmarkfeat #d-tbc p{    font-size: 16px;}
.landmarkfeat  #d-tbc li img{    padding-top: 40px;}
.landmarkfeat #d-tbc h3 { font-size: 23px !important;}

@media only screen and (min-width : 320px) and (max-width : 767px) 
{
    .home #icl_lang_sel_widget-2 .wpml-ls-legacy-list-horizontal{    margin: 0px !important;    float: none !important;}
    .main_header_right a{    float: left;    margin-top:33px !important;    padding: 6px 0 !important;    width: 100% !important;}
    .for_garage{   margin-top:0px !important;  }
    .tm_pb_section.main_top_slider {    display: block !important;}
    .slider_top_content {    padding: 35px 0 0 !important;}
    #tm_builder_outer_content .tm_pb_module img{    height: auto !important;    padding-top: 0 !important;}
    .border_box .tm_pb_column_1_2:nth-of-type(1) {    border-right: none!important;}
    .about_img_center {    padding-top: 0px !important;}
    .bighead h2{font-size: 35px !important;}
    .inner_box_rich {    padding-bottom: 0!important;}
    .main_gallery h3, .main_why_rich h2{    padding-top: 60px!important;}
    .main_gallery h3, .main_why_rich h2{    padding-top: 0!important;}
    .main_header_right a{    display: none;}
  .page .superfly-on .sfm-rollback{    top: 37px;  left: -31px;}
    .main_gallery h3{padding-top: 55px !important;}
    .home .superfly-on .sfm-rollback{top: 30px;    left: -5px;}
    .page .sfm-rollback.sfm-color1.sfm-theme-none.sfm-label-visible.sfm-label-metro {    margin: 0 0 0 0px !important;}
    .home .sfm-rollback.sfm-color1.sfm-theme-none.sfm-label-visible.sfm-label-metro {    margin: -6px 0 0 0 !important;}
    .slider_over {    display: block !important;}
    .slider_top_content {    padding: 17px 0 0 !important;}
}

@media only screen and (min-width : 320px) and (max-width : 767px)  and (orientation : portrait)
{
       /*#tm_builder_outer_content .tm_pb_module img {    width: 100% !important;}*/
       .inner_box_rich_img {width: 100%;    float: left;    text-align: center;}
       .inner_box_rich_txt {    width: 100%;    text-align: center;}
       .authodeal{padding-top: 25px;}
}
@media only screen and (min-width : 320px) and (max-width : 767px)  and (orientation : landscape)
{
     .authodeal img{width: 200px !important;}
}
.widget widget_icl_lang_sel_widget{display:none;}
.d-info #brochures a{padding-right: 4%;}
.landmarkfeat #d-tbc li img{    padding-top: 25px;    float: left;    padding-right: 15px;}
.contact-info .contact a{font-size: 17px;}
.page-id-1644 h4{font-size: 29px;}
</style>

<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">





</head>

<body <?php body_class(); ?>>
<div class="overlay"></div>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'monstroid2' ); ?></a>
    <header id="masthead" <?php monstroid2_header_class(); ?> role="banner">
        <?php monstroid2_ads_header() ?>
        <?php get_template_part( 'template-parts/header/mobile-panel' ); ?>
        <?php get_template_part( 'template-parts/header/top-panel', get_theme_mod( 'header_layout_type' ) ); ?>

        <div <?php monstroid2_header_container_class(); ?> id="for_mobile">
        <?php get_template_part( 'template-parts/header/layout', get_theme_mod( 'header_layout_type' ) ); ?>
        </div><!-- .header-container -->

        <div <?php monstroid2_header_container_class(); ?>>
<div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main_header">

<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 main_header_left text-center paddingnone" id="for_desk">
<!-- <a href="http://www.rwdoors.com/"><img src="/wp-content/uploads/2017/06/RW_Logo.png" alt="rwdoors" class="site-link__img"></a> -->
<a href="<?php echo home_url(); ?>"> <?php dynamic_sidebar( 'top-logo' ); ?> </a>
</div>

<div class="col-lg-8 col-md-9 col-sm-12 col-xs-12 main_header_right paddingnone">

<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 header_right paddingnone">
    <?php //echo do_shortcode( '[widget id="icl_lang_sel_widget-2"]' ); ?>
    <div id="icl_lang_sel_widget-2" class="widget widget_icl_lang_sel_widget" >
<div class="wpml-ls-sidebars-arbitrary wpml-ls wpml-ls-legacy-list-horizontal">
	<ul><li class="wpml-ls-slot-arbitrary wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-list-horizontal">
				<a href="https://www.rwdoors.com/" class="wpml-ls-link"><span class="wpml-ls-native">English</span></a>
			</li><li class="wpml-ls-slot-arbitrary wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-list-horizontal"><a>|</a></li></li><li class="wpml-ls-slot-arbitrary wpml-ls-item wpml-ls-item-fr wpml-ls-item-legacy-list-horizontal">
				<a href="https://www.rwdoors.com/fr/" class="wpml-ls-link"><span class="wpml-ls-display"> Français </span></a>
			</li><li class="wpml-ls-slot-arbitrary wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-list-horizontal"><a>|</a></li><li class="wpml-ls-slot-arbitrary wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-list-horizontal">
				<a href="https://www.rwdoors.com/es/" class="wpml-ls-link"><span class="wpml-ls-display"> Español</span></a>
			</li></ul>
</div></div>
<a class="ondesktop headphn" style="color: #d72430 !important;">1(800) 667-1572</a>
<?php
if (ICL_LANGUAGE_CODE == "fr") { ?>

   <a class="onmob fr_btn_top_right" href="https://www.rwdoors.com/fr/dealers/">Trouver un revendeur</a>
<?php } elseif (ICL_LANGUAGE_CODE == "es") { ?>
    <a class="onmob fr_btn_top_right" href="https://www.rwdoors.com/es/dealers/">Encontrar un distribuidor</a>
    
<?php } else {?>
    <a class="onmob " href="/dealers/">Find A Dealer</a>
<?php }
?>

<?php
if (ICL_LANGUAGE_CODE == "fr") { ?>
   <a class="for_garage onmob fr_btn_top_right" href="https://www.rwdoors.com/select-your-door/fr/beautyshots.html">Sélectionnez votre porte</a>
<?php } elseif (ICL_LANGUAGE_CODE == "es") { ?>
    <a class="for_garage onmob fr_btn_top_right" href="https://www.rwdoors.com/select-your-door/es/beautyshots.html">Seleccione su puerta</a>
    
<?php } else {?>
    <a class="for_garage onmob" href="https://www.rwdoors.com/select-your-door/beautyshots.html">Select Your Door</a>
<?php }
?>


<a class="for_overhead ondesktop" href="https://www.rwdoors.com/architects">Architects</a>

<div class="sfm-rollback sfm-color1 sfm-theme-none sfm-label-visible sfm-label-metro">
    <div class="sfm-navicon-button x sf_label_default"><div class="sfm-navicon"></div></div>
</div>

</div>
</div>

</div></div>
        </div><!-- .header-container -->

    </header><!-- #masthead -->

    <div id="content" <?php monstroid2_content_class(); ?>>
