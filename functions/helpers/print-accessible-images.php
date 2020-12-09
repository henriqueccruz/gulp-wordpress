<?php
/**
 * Prints accessible images with all tags available
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

function print_accessible_image($image, $attr = FALSE) {

	// Set our image ID
	$image_id = (is_numeric($image)) ? 
					$image : 
					((is_array($image) && array_key_exists('ID', $image)) ? $image['ID'] : false );

	// Check if the ID is from an image. If not, let's try to grab the thumbnail.
	$supposed_image = get_post_type($image_id);
	if($supposed_image !== 'attachment') {
		$image_id = get_post_thumbnail_id($image_id);

		if(is_null($image_id)) {
			return false;
		}
	}

	// Set target image size
	$img_size = ($attr && array_key_exists('size', $attr)) ? $attr['size'] : 'medium';

	if($attr) {
		$html_attr = '';

		// Set id for the tag
		if(array_key_exists('id', $attr)) {
			$html_attr .= "id='{$attr['id']}'";
		}

		// Set classes for our image tag
		if(array_key_exists('classes', $attr)) {

			$class_count = 0;
			$html_attr .= 'class="';

			foreach($attr['classes'] as $class) {
				$html_attr .= ($class_count > 0) ? ' ' : '';
				$html_attr .= $class;
				$class_count++;
			}
			$html_attr .= '"';
		}

		// Set additional attrs
		if(array_key_exists('attrs', $attr)) {
			foreach($attr['attrs'] as $key => $value) {
				$html_attr .= ($html_attr !== '') ? ' ' : '';
				$html_attr .= "{$key}='{$value}'";
			}
		}

	}

	// Set our draggable attr if not setted yet
	if(!$attr || (is_array($attr) && array_key_exists('attrs', $attr) && !array_key_exists('draggable', $attr['attrs']))) {
		$html_attr .= " draggable='false'";
	}

	if(is_array($image)) {

		// Print title
		if(array_key_exists('title', $image)) {
			$html_attr .= ($html_attr !== '') ? ' ' : '';
			$html_attr .= "title='{$image['title']}'";
		}
	
		// Print alt
		if(array_key_exists('alt', $image)) {
			$html_attr .= ($html_attr !== '') ? ' ' : '';
			$html_attr .= "alt='{$image['alt']}'";
		}

		// Print sizes
		if(array_key_exists('sizes', $image)) {
			$html_attr .= " width='{$image['sizes'][$img_size."-width"]}' height='{$image['sizes'][$img_size."-height"]}'";
		}
	}

	// Get srcset
	$srcset = wp_get_attachment_image_srcset($image_id, $img_size);

	// Decide which image size is most suitable
	if(is_array($image) && isset($img_size) && array_key_exists('sizes', $image)) {
		$img_url = ($img_size == 'full') ? wp_get_original_image_url( $image_id ) : $image['sizes'][$img_size];
	} else {
		$img_url = wp_get_original_image_url( $image_id );
	}

	// Create our tag
	$output = "<img src='{$img_url}' {$html_attr} srcset='{$srcset}' />";
	
	return $output;

}