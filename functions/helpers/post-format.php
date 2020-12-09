<?php
/**
 * Post format functions and abstractions
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

class YouTubeLinkParser {
	
	function __construct($video_url) {
		$this->video_id = $this->get_video_id($video_url);
	}

	protected function get_video_id($url) {
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
		$youtube_id = $match[1];
	
		return $youtube_id;
	}

	public function get_id() {
		return $this->video_id;
	}

	public function get_video_thumbnail() {
		return "https://img.youtube.com/vi/{$this->video_id}/0.jpg";
	}

	public function get_video_embed_url() {
		return "https://www.youtube.com/embed/{$this->video_id}";
	}

	public function get_video_embed() {
		$embed_url = $this->get_video_embed_url();
		return "<iframe width='560' height='315' src='{$embed_url}' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
	}
}

function custom_excerpt_length( $length ) {
	return 26;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

$page_anchors = [];

function tax_cat_active($output, $args) {
    if (is_single()) {
        global $post;
        $terms = get_the_terms($post->ID, 'category');
        if (!empty($terms)) {
            foreach( $terms as $term )
                if ( preg_match( '#cat-item-' . $term ->term_id . '#', $output ) )
                    $output = str_replace('cat-item-'.$term ->term_id, 'cat-item-'.$term ->term_id . ' current-cat', $output);
        }
    }
    return $output;
}
add_filter('wp_list_categories', 'tax_cat_active', 10, 2); 