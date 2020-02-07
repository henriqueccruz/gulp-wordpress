<?php
/**
 * Style functions
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
 */

/**
 * Enqueue theme styles.
 */
function gulp_wp_theme_styles() {

	global $theme_handle_prefix;

	wp_register_style( $theme_handle_prefix . '-styles', get_template_directory_uri() . '/assets/css/style.min.css', array(), '1.0.0', 'all' );
	//wp_register_style( 'fancybox', get_template_directory_uri() . '/assets/css/libs/jquery.fancybox.min.css', array(), '3.5.7', 'all' );
	
	wp_enqueue_style( $theme_handle_prefix . '-styles' );
	//wp_enqueue_style( 'fancybox' );

}
add_action( 'wp_enqueue_scripts', 'gulp_wp_theme_styles' );
