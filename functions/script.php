<?php
/**
 * Script functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Enqueue theme scripts
 */
function gulp_wp_theme_scripts() {

	global $theme_handle_prefix;

	/**
	 * Enqueue common scripts.
	 */
	wp_register_script( $theme_handle_prefix . '-scripts', get_template_directory_uri() . '/assets/js/theme.min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( $theme_handle_prefix . '-scripts' );

	wp_register_script( 'tiny-slider', get_template_directory_uri() . '/assets/js/libs/tiny-slider.min.js', array('jquery'), '2.9.3', true );
	wp_register_script( 'fancybox', get_template_directory_uri() . '/assets/js/libs/jquery.fancybox.min.js', array('jquery'), '3.0.6', true );
	wp_register_script( 'infinite-scroll', get_template_directory_uri() . '/assets/js/libs/infinite-scroll.pkgd.min.js', array('jquery'), '3.0.6', true );
	wp_enqueue_script( 'tiny-slider' );
	wp_enqueue_script( 'fancybox' );

	wp_localize_script( $theme_handle_prefix . '-scripts', 'global_vars',
	array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	if(is_archive()) {
		wp_enqueue_script( 'infinite-scroll' );
	}
}
add_action( 'wp_enqueue_scripts', 'gulp_wp_theme_scripts' );
