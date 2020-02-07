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
$theme_handle_prefix = '<Package>';

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
 * Define our theme sizes
 */
require_once "helpers/_helpers.php";

/**
 * Initialize custom post types
 */

// Initialize subscribers CTP
require_once 'cpts/_init.php';