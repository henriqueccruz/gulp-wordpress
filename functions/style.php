<?php
/**
 * Style functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Enqueue theme styles.
 */
function gulp_wp_theme_styles() {

	global $theme_handle_prefix;

	wp_register_style( $theme_handle_prefix . '-styles', get_template_directory_uri() . '/assets/css/style.min.css', array(), '1.0.0', 'all' );
	wp_register_style( 'about-styles', get_template_directory_uri() . '/assets/css/layout/pages/about.min.css', array(), '1.0.0', 'all' );
	wp_register_style( 'dealers-styles', get_template_directory_uri() . '/assets/css/layout/pages/dealers.min.css', array(), '1.0.0', 'all' );
	wp_register_style( 'contact-styles', get_template_directory_uri() . '/assets/css/layout/pages/contact.min.css', array(), '1.0.0', 'all' );
	wp_register_style( 'archive-styles', get_template_directory_uri() . '/assets/css/layout/pages/archive.min.css', array(), '1.0.0', 'all' );
	wp_register_style( 'single-post-styles', get_template_directory_uri() . '/assets/css/layout/pages/single.min.css', array(), '1.0.0', 'all' );
	wp_register_style( 'slick', get_template_directory_uri() . '/assets/css/libs/slick.css', array(), '3.5.7', 'all' );
	wp_register_style( 'slick-theme', get_template_directory_uri() . '/assets/css/libs/slick-theme.css', array(), '3.5.7', 'all' );
	wp_register_style( 'fancybox', get_template_directory_uri() . '/assets/css/libs/jquery.fancybox.min.css', array(), '3.5.7', 'all' );
	
	wp_enqueue_style( $theme_handle_prefix . '-styles' );
	wp_enqueue_style( 'slick' );
	wp_enqueue_style( 'slick-theme' );
	wp_enqueue_style( 'fancybox' );

	if(is_page('quem-somos'))
		wp_enqueue_style( 'about-styles' );

	if(is_page('dealers'))
		wp_enqueue_style( 'dealers-styles' );

	if(is_page('fale-conosco'))
		wp_enqueue_style( 'contact-styles' );

	if(is_archive())
		wp_enqueue_style( 'archive-styles' );

	if(is_singular(array('post', 'eventos')))
		wp_enqueue_style( 'single-post-styles' );

}
add_action( 'wp_enqueue_scripts', 'gulp_wp_theme_styles' );