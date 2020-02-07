<?php
/**
 * Comment removal and related functions
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
 */

function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	// Disable only for attachment pages
    /*if( $post->post_type == 'attachment' || $post->post_type == 'post' ) {
        return false;
    }
	return $open;*/
	
	return false;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );