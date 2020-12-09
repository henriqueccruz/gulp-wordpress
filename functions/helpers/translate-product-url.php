<?php
/**
 * Translates a Product URL to the parent page
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

add_filter( 'post_type_link', 'wpse_64285_external_permalink', 10, 4 );

/**
 * Parse post link and replace it with meta value.
 *
 * @wp-hook post_link
 * @param   string $link
 * @param   object $post
 * @return  string
 */
function wpse_64285_external_permalink( $post_link, $post, $leavename, $sample ) {

	if(function_exists('get_field')) {

		if($post instanceof WP_Post && $post->post_type == 'products') {
			
			$product_meta = get_fields($post->ID);
			
			$original_name = $post->post_name;
			$block_title = $product_meta['block_title'];

			$product_permalink = get_permalink($product_meta['main_product']->ID);
			$post_link = esc_url( filter_var( $product_permalink.'#!/'.slugify( (!empty(trim($block_title))) ? trim($block_title) :  $original_name ), FILTER_VALIDATE_URL ) );
		}
	}

    return $post_link;
}

if(!is_admin()) {
	add_filter('the_title', 'change_title', 10, 2);
}

function change_title($title, $id) {

	if (get_post_type($id) == "products")  {
	
		if(function_exists('get_field')) {
			
			$product_meta = get_fields($id);
			
			$original_name = $post->post_title;
			$block_title = (is_array($product_meta) && array_key_exists('block_title', $product_meta)) ? $product_meta['block_title'] : NULL;

			if(!empty(trim($block_title))) {
				$title = $block_title;
			}
		}
	}

    return $title;
}