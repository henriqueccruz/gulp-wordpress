<?php
/**
 * Admin functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Credit in admin footer
 */
function gulp_wp_admin_footer() {
	echo 'Desenvolvido para a <a href="http://okean.com.br/" target="_blank">Okean Embarcações</a> pela <a href="https://www.futurebrand.com/br" target="_blank">FutureBrand</a>';
}
add_filter( 'admin_footer_text', 'gulp_wp_admin_footer' );

/**
 * Change default greeting
 */
function gulp_wp_greeting( $wp_admin_bar ) {
	$user_id = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url = get_edit_profile_url( $user_id );

	if ( 0 !== $user_id ) {

		date_default_timezone_set('America/Sao_Paulo');
		$current_hour = (int) date('H');
		
		$greeting = ($current_hour >= 18 || $current_hour <= 4) ? 'Boa noite' : 
					(($current_hour > 4 && $current_hour < 12) ? 'Bom dia' : 'Boa tarde');
					
		$avatar = get_avatar( $user_id, 28 );
		$howdy = sprintf( __( $greeting.', %1$s' ), $current_user->display_name );
		$class = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu(array(
			'id' => 'my-account',
			'parent' => 'top-secondary',
			'title' => $howdy . $avatar,
			'href' => $profile_url,
			'meta' => array(
				'class' => $class,
			),
		));
	}
}
add_action( 'admin_bar_menu', 'gulp_wp_greeting', 11 );

/**
 * Initialize website options page
 */

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Opções do site',
		'menu_title'	=> 'Opções do tema',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}