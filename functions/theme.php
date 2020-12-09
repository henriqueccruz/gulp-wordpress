<?php
/**
 * Base functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Set a script handle prefix based on theme name.
 * Note that this should be the same as the `themePrefix` var set in your Gulpfile.js.
 */
$theme_handle_prefix = 'wp-gulp-boilerplate';

/**
 * Define theme constants and everything generic
 */
add_theme_support( 'post-thumbnails' );

/**
 * Define our theme sizes
 */
add_image_size( 'minor-highlight', 435, 435, true );
add_image_size( 'medium-crop', 300, 300, true );
add_image_size( 'header-background', 1500, 600, true );

/**
 * Define max-width for srcset functions
 */
add_filter('max_srcset_image_width', function() {
	return 2000;
});

/**
 * Functions and helpers
 */
require_once "helpers/_helpers.php";

/**
 * Initialize custom post types
 */

// Initialize subscribers CTP
require_once 'cpts/_cpts.php';