<?php
/**
 * Menu functions
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
 */

/**
 * Register nav menus
 */
function gulp_wp_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary' ),
		)
	);
}
add_action( 'init', 'gulp_wp_register_menus' );
