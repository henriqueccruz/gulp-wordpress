<?php
/**
 * Implements custom filters for the search page
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

add_filter('query_vars', 'search_product_id');
function search_product_id($qv) {
	$qv[] = 'product_id';
	return $qv;
}

add_filter('relevanssi_modify_wp_query', 'rlv_add_product_meta_query');
function rlv_add_product_meta_query($query) {
	if (isset($query->query_vars['product_id'])) {
		if (!empty($query->query_vars['product_id'])) {
			$meta_query = array(
				array(
					'key' 		=> 'main_product',
					'value'		=> $query->query_vars['product_id'],
					'compare' 	=> '=',
				),
				array(
					'key' 		=> 'page_post_id',
					'value'		=> $query->query_vars['product_id'],
					'compare' 	=> '=',
				),
				'relation' => 'OR',
			);
			$query->set('meta_query', $meta_query);
		}
	}
	return $query;
}

add_action('save_post_page', 'post_id', 100);

function post_id( $postId ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    } else {    
        add_post_meta($postId, 'page_post_id', $postId);
    }

}