<?php
/**
 * Script functions
 *
 * @package Adapt WordPress Theme
 * @subpackage Functions
 * @version 3.0.0
 */

/**
 * Loads theme css and js files
 *
 * @since 1.0.0
 */
function wpex_load_scripts() {
	
	// CSS
	wp_enqueue_style( 'wpex-style', get_stylesheet_uri() );
	wp_enqueue_style( 'prettyPhoto', WPEX_CSS_DIR . '/prettyPhoto.css', array(), '3.1.6' );
	wp_enqueue_style( 'font-awesome', WPEX_CSS_DIR . '/font-awesome.min.css', array(), '4.5.0' );
	wp_enqueue_style( 'google-font-droid-serif', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' );
	if ( wpex_get_data( 'responsive', '1' ) == '1' ) {
		wp_enqueue_style( 'responsive', WPEX_CSS_DIR . '/responsive.css', array( 'wpex-style' ) );
	}
	
	// JS
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'slicknav', WPEX_JS_DIR. '/jquery.slicknav.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'hoverIntent', WPEX_JS_DIR. '/hoverIntent.js', array( 'jquery' ), 'r7', true );
	wp_enqueue_script( 'superfish', WPEX_JS_DIR. '/superfish.js', array( 'jquery', 'hoverIntent' ), '1.7.9', true );
	wp_enqueue_script( 'fitvids', WPEX_JS_DIR. '/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_enqueue_script( 'prettyPhoto', WPEX_JS_DIR. '/jquery.prettyPhoto.js', array( 'jquery' ), '3.1.6', true );
	
	$deps = array( 'jquery', 'slicknav', 'hoverIntent', 'superfish', 'fitvids', 'prettyPhoto' );
	wp_enqueue_script( 'wpex-global', WPEX_JS_DIR . '/global.js', $deps, '3.0.0', true );
	wp_localize_script( 'wpex-global', 'wpexLocalize', array(
		'mobileMenuText' => wpex_get_data( 'responsive_menu_text', __( 'Menu', 'wpex-adapt' )
	) ) );

	wp_register_script( 'flexslider', WPEX_JS_DIR. '/jquery.flexslider.js', array( 'jquery' ), '2.2.2', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( wpex_get_data ( 'builtin_retina', '0' ) == '1' ) {
		wp_enqueue_script( 'retina', WPEX_JS_DIR . '/retina.js', array( 'jquery' ), '', true );
	}
	
}
add_action( 'wp_enqueue_scripts', 'wpex_load_scripts' );

/**
 * Browser specific CSS
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_browser_dependencies' ) ) {
	function wpex_browser_dependencies() {
		echo '<!--[if lt IE 9]>';
			echo '<link rel="stylesheet" type="text/css" href="'. WPEX_CSS_DIR .'/ancient-ie.css" />';
			echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
	}
}
add_action( 'wp_head', 'wpex_browser_dependencies' );

/**
 * Retina logo output
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_retina_logo' ) ) {
	function wpex_retina_logo() {
		
		if ( wpex_get_data( 'custom_retina_logo' )
			&& wpex_get_data( 'logo_height' )
			&& wpex_get_data( 'logo_width' )
		) {
		
			// Get retina options from theme panel and set vars
			$logo_url    = wpex_get_data( 'custom_retina_logo' );
			$logo_width  = wpex_get_data( 'logo_height' );
			$logo_height = wpex_get_data( 'logo_width' );
					
			$wpex_retina_logo_js = '<!-- Retina Logo -->
			<script type="text/javascript">
			jQuery(function($){
				if (window.devicePixelRatio == 2) {
					$("#masterhead #logo img").attr("src", "'. $logo_url .'");
					$("#masterhead #logo img").attr("width", "'. $logo_width .'");
					$("#masterhead #logo img").attr("height", "'. $logo_height .'");
				 }
			});
			</script>';	
			
			// Remove spacing from js for speed
			$wpex_retina_logo_js =  preg_replace( '/\s+/', ' ', $wpex_retina_logo_js );
			
			// Output the custom retina logo js
			echo $wpex_retina_logo_js;
		
		}
		
	}
}
add_action( 'wp_head', 'wpex_retina_logo' );

/**
 * Site tracking output
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_site_tracking' ) ) {
	function wpex_site_tracking() {
		if ( $tracking = wpex_get_data( 'google_analytics' ) ) {
			echo $tracking;
		}
	}
}
add_action( 'wp_head', 'wpex_site_tracking' );