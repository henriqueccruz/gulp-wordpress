<?php
/**
 * Menu functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Register nav menus
 */
function gulp_wp_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Navegação do Header' ),
		)
	);
}
add_action( 'init', 'gulp_wp_register_menus' );

/**
 * Print language selector
 */
function add_lang_to_nav( $items, $args ) {

	if(!function_exists('qtranxf_get_url_for_language'))
		return $items;

    $items .= '<li class="lang-select">'.get_lang_menu().'</li>';
	return $items;
	
}
add_filter( 'wp_nav_menu_items', 'add_lang_to_nav', 10, 2 );