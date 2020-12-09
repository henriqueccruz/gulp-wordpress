<?php
/**
 * Limit search results for the preview page
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */
	
add_filter( 'post_limits', 'rlv_postsperpage' );
function rlv_postsperpage( $limits ) {
	if ( is_search() && isset($_GET) && $_GET['is_preview'] == 1 ) {
		global $wp_query;
		$wp_query->query_vars['posts_per_page'] = 6;
	}
	return $limits;
}