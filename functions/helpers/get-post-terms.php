<?php
/**
 * Returns a list with the terms associated with a post
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

function get_term_ids($post) {	
	$term_list = wp_get_post_terms($post->ID, 'category');
	return $term_list;
}

function get_post_label($post) {

	switch($post->post_type) {
		case('page'):
			return ($post->post_parent == (get_page_by_path( 'produtos' ))->ID) ? 'Produtos' : 'Institucional';
			break;
		case('products'):
			return 'Produtos';
			break;
		case('post'):
			$post_terms = get_term_ids($post);
			$main_term = array_shift($post_terms);
			return $main_term->name;
			break;
	}

}

function print_post_label() {
	global $post;
	echo get_post_label($post);
}