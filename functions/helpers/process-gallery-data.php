<?php
/**
 * Process data for use in our galleries
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

function process_gallery_data($row, $args = NULL) {

	if($row instanceof WP_Post) {
		$post_id = $row->ID;
	} elseif(is_array($row) && array_key_exists('ID', $row)) {
		$post_id = $row['ID'];
	}

	$image = ($args && array_key_exists('meta_key', $args)) ? 
				get_post_meta(((isset($post_id)) ? $post_id : $row), $args['meta_key'], true) : (
				(is_array($row)) ? 
					$row['image'] : 
					$row
				);

	if(empty($image)) {
		return false;
	}

	$desktop_image = print_accessible_image($image, ['size' => 1600]);

	$mobile_image = print_accessible_image($image.'_mobile', ['size' => 1600]);
	if(!($row instanceof WP_Post)) {
		$mobile_image = (strlen($mobile_image) > 30) ? $mobile_image : print_accessible_image($row['image_mobile'], ['size' => 1600]);
	}
	
	if($mobile_image && strlen($mobile_image) > 30) {
		$content = '<div class="hide-mobile">'.$desktop_image.'</div>';
		$content .= '<div class="hide-desktop">'.$mobile_image.'</div>';
	} else {
		$content = $desktop_image;
	}

	if($args && is_array($args)) {

		$content .= '<div class="text-container">';

		/* Insert title if slider is configured to do so */
		if(array_key_exists('item_title', $args) || array_key_exists('title', $row)) {
			$title_tag = (array_key_exists('title_tag', $args)) ? $args['title_tag'] : 'h3';
			$title = (array_key_exists('title', $row)) ? $row['title'] : $row[$args['item_title']];
			$content .= "<{$title_tag} class='slide_header'>{$title}</{$title_tag}>";
		}

		/* Insert description if slider is configured to do so */
		if(array_key_exists('item_desc', $args) || array_key_exists('text', $row)) {
			$description = (array_key_exists('text', $row)) ? $row['text'] : $row[$args['item_desc']];
			$content .= "<p class='slide_content'>{$description}</p>";
		}
		
		$content .= '</div>';

		/* Prints a youtube link if the item has it */
		if(array_key_exists('video', $args) && $args['video'] = true) {
			$link = $row['video'];

			if(!empty($link)) {
				$youtube = new YouTubeLinkParser($link);
				$embed_link = $youtube->get_video_embed_url();

				$embed_link .= (array_key_exists('autoplay', $args) && $args['video'] = true) ? '' : '?autoplay=1';

				$content = "<a data-fancybox data-type='iframe' class='product-video' href='{$embed_link}'>{$content}</a>";
			}

		}

		/* Create a header tag if the slider is a product */
		if(array_key_exists('show_header', $args) && $args['show_header'] == true && array_key_exists('show_header', $args)) {
			$icon = get_field($args['header_logo'], $post_id);
			$desc = get_field($args['header_desc'], $post_id);

			$header_content = '';

			if(!empty($icon)) {
				$link = get_the_permalink($post_id);
				//$header_content .= "<h3 class='product-title'>".print_svg_ico($icon)."</h3>";
				$header_content .= "<h3 class='product-title'>".print_product_title($post_id)."</h3>";
				$header_content .= "<a class='product-link' href='{$link}'>Conheça</a>";
			}

			if(!empty($desc)) {
				$header_content .= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ornare <br>
				neque ac ligula semper, at bibendum nisl lacinia. Proin gravida molestie.</p>";
			}

			if(!empty($header_content)) {
				$content .= "<header class='product_header'>{$header_content}</header>";
			}

		}
	
		/* Create a link tag if slider is configured to do so */
		if(array_key_exists('item_link', $args) || array_key_exists('link', $row)) {
			/*if($args['item_link'] == 'permalink') {
				$link = get_the_permalink($post_id);
			} else {
				$link = $row[$args['item_link']]['url'] . '?download';
			}*/

			$link = $row[$args['item_link']]['url'] . '?download';
			$target = ($args['item_link'] == 'permalink') ? '_self' : '_blank';

			$content = "<a href='{$link}' target='{$target}'>{$content}</a>";
		}
	
		/* Determine wether the item should have a specific class */
		$item_class = (array_key_exists('item_class', $args)) ? $args['item_class'] : '';

	}

	$return_data = compact('item_class', 'content', 'description');

	return $return_data;

}