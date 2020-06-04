<?php
/**
 * Initialize single embarcacoe CTP
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

// Register Custom Post Type
function init_embarcacoes_ctp() {

	$labels = array(
		'name'                  => 'Embarcações',
		'singular_name'         => 'Embarcação',
		'menu_name'             => 'Embarcações',
		'name_admin_bar'        => 'Embarcação',
		'all_items'             => 'Todos os Embarcações',
		'add_new_item'          => 'Adicionar nova Embarcação',
		'add_new'               => 'Adicionar nova',
		'new_item'              => 'Nova Embarcação',
		'edit_item'             => 'Editar Embarcação',
		'update_item'           => 'Atualizar Embarcação',
		'view_item'             => 'Visualizar Embarcação',
		'view_items'            => 'Visualizar Embarcações',
		'search_items'          => 'Pesquisar Embarcações',
		'not_found'             => 'Não encontrada',
		'not_found_in_trash'    => 'Não encontrada na lixeira',
	);

	$args = array(
		'label'                 => 'Embarcação',
		'description'           => 'Embarcações cadastradas para exibição no site.',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-star-filled',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	
	register_post_type( 'embarcacoes', $args );

	// Create custom taxonomy
	register_taxonomy( 
		'tipo-embarcacoes', //taxonomy 
		'embarcacoes', //post-type
		array( 
			'hierarchical'  => true, 
			'label'         => __( 'Tipos de embarcação' ), 
			'singular_name' => __( 'Tipo de embarcação' ), 
			'rewrite'       => true, 
			'query_var'     => true 
		)
	);

}

add_action( 'init', 'init_embarcacoes_ctp', 0 );