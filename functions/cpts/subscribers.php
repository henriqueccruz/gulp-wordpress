<?php
/**
 * Initialize portfólio CTP
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
 */

// Register Custom Post Type
function init_works_ctp() {

	$labels = array(
		'name'                  => 'Itens do Portfólio',
		'singular_name'         => 'Portfólio',
		'menu_name'             => 'Itens do portfólio',
		'name_admin_bar'        => 'Portfólio',
		'all_items'             => 'Todos os itens do Portfólio',
		'add_new_item'          => 'Adicionar novo Portfólio',
		'add_new'               => 'Adicionar novo',
		'new_item'              => 'Novo portfólio',
		'edit_item'             => 'Editar portfólio',
		'update_item'           => 'Atualizar portfólio',
		'view_item'             => 'Visualizar portfólio',
		'view_items'            => 'Visualizar portfólios',
		'search_items'          => 'Pesquisar portfólios',
		'not_found'             => 'Não encontrado',
		'not_found_in_trash'    => 'Não encontrado na lixeira',
	);

	$args = array(
		'label'                 => 'Portfólio',
		'description'           => 'Itens do portfólio cadastrados para exibição no site.',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-star-filled',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	
	register_post_type( 'works', $args );

}
add_action( 'init', 'init_works_ctp', 0 );

// Function to get the client ip address
function get_client_ip_server() {

	if ($_SERVER['HTTP_CLIENT_IP'])
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if($_SERVER['HTTP_X_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if($_SERVER['HTTP_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if($_SERVER['HTTP_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if($_SERVER['REMOTE_ADDR'])
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		return false;

	return $ipaddress;
}