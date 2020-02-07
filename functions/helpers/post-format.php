<?php
/**
 * Post format functions and abstractions
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
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

	public function get_video_embed() {
		return "<iframe width='560' height='315' src='https://www.youtube.com/embed/{$this->video_id}' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
	}
}

function print_gallery_shortcode($img_list) {
	if(!is_array($img_list) || empty($img_list)) {
		return false;
	}

	$img_ids = '';
	$i = 0; foreach($img_list as $img) {
		$img_ids .= (($i == 0) ? '' : ',') . $img['image']['ID'];
		$i++;
	}

	return "[gallery ids='{$img_ids}' columns='4' size='minor-highlight' link='file']";

}

function print_sidebar() {

	// If is search or homepage, print default boxes
	if (is_search() || is_home()) {
		//$sidebar_config = get_field('abas', 'options');
		//print_r($sidebar_config);
		//print_r(get_option('abas'));

	// If is a category page
	} elseif(is_category()) {
		$queried_object = get_queried_object_id();
		$sidebar_config = get_field('abas', "category_{$queried_object}");

	// If is a single post
	} elseif(is_single()) {
		$queried_object = get_queried_object_id();
		$sidebar_config = get_field('abas', $queried_object);

	// In all other cases, do nothing.
	} else {
		return '';
	}

	$return = '';
	while (have_rows('abas', 'options')) {

		the_row();
		$tab_format = get_sub_field('_tab_format');

		switch($tab_format) {
			case 'link':

				$image = get_sub_field('_tab_image');

				$return .= '<div class="block"><div class="content">';

				if ( get_sub_field('_target_url') == "[newsletter]" ) {
					$return .= '<a href="javascript:;" data-newsletter >';
				} else {
					$return .= '<a href="'.get_sub_field('_target_url').'" '.((get_sub_field('_target_config')) ? '' : 'target="_blank"').'>';
				}
				
				$return .= '<img src="'.((empty($image['url'])) ? '#' : $image['url']).'" alt="'.$image['alt'].'" title="'.$image['title'].'" width="'.$image['width'].'" height="'.$image['height'].'" style="max-width:100%">';
				$return .= '</a>';

				$return .= '</div></div>';

				break;

			case 'post':
			
				$post_id = get_sub_field('_target_post')->ID;

				$post_categories = wp_get_post_categories( $post_id );
				$c = array_shift($post_categories);

				$cat = get_category( $c );
				$category_color = get_term_meta($cat->term_id, '_category_color', true);

				$return .= '<div class="block post-link" style="background-color: '.$category_color.'"><div class="content">';

				$is_video = (get_post_format($post_id) == 'video');
				$post_link = ($is_video) ? get_field('_video_link', $post_id) : get_permalink(get_sub_field('_target_post')->ID);

				if($is_video) {
					$video = new YouTubeLinkParser($post_link);
					$video_id = $video->get_id();
					$post_link = 'https://www.youtube.com/embed/'.$video_id;

				}

				$return .= '<a '.(($is_video) ? 'data-fancybox' : '').' href="'.$post_link.'" '.((!$is_video) ? '' : 'target="_blank"').' class="'.(($is_video) ? 'lightbox' : '' ).'">';
				$return .= '<strong>' . ((CURRENT_LANGUAGE == 'pb') ? 'Veja também' : 'Ve también' ) . ':</strong>';

				$return .= '<div class="thumbnail-container">'.get_the_post_thumbnail(get_sub_field('_target_post'), 'medium').'</div>';

				$return .= '<h5>'.get_sub_field('_target_post')->post_title.'</h5>';
				$return .= '</a>';

				$return .= '</div></div>';
				
				break;

			case 'video':	

				$image = get_sub_field('_tab_image');

				$return .= '<div class="block"><div class="content">';

				$return .= '<a data-fancybox class="lightbox" href="'.get_sub_field('_target_video').'" '.((get_sub_field('_target_config')) ? '' : 'target="_blank"').'>';
				$return .= '<img src="'.((empty($image['url'])) ? '#' : $image['url']).'" alt="'.$image['alt'].'" title="'.$image['title'].'" width="'.$image['width'].'" height="'.$image['height'].'">';
				$return .= '</a>';

				$return .= '</div></div>';

				break;
		}

	}

	return $return;
}