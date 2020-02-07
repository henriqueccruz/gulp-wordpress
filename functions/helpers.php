<?php
/**
 * Theme functions and helpers
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
 */

// Print accessible imagens with all tags available
function print_accessible_image($image, $attr = FALSE) {

	if(!(is_array($image))) {
		return;
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

	// Get srcset
	$srcset = wp_get_attachment_image_srcset($image['ID'], $img_size);
	$img_url = ($img_size == 'full') ? wp_get_original_image_url( $image['ID'] ) : $image['sizes'][$img_size];

	// Create our tag
	$output = "<img src='{$img_url}' {$html_attr} width='{$image['sizes'][$img_size."-width"]}' height='{$image['sizes'][$img_size."-height"]}' srcset='{$srcset}' />";
	
	return $output;

}

// Print inline SVGs for styling and better organisation
function print_svg_ico($ico_name, $attr = NULL) {

	$path = get_stylesheet_directory() ."/assets/images/";
	$path .= ($attr && array_key_exists('dir', $attr)) ? "{$attr['dir']}/" : "";
	$path .= "{$ico_name}.svg";
	
	$svg_markup = file_get_contents( $path );

	return $svg_markup;
}

// Return Video ID from Youtube URL
function get_youtube_video_id($video_url) {
    $parts = parse_url($video_url);
    if(isset($parts['query'])){
        parse_str($parts['query'], $qs);
        if(isset($qs['v'])){
            return $qs['v'];
        }else if(isset($qs['vi'])){
            return $qs['vi'];
        }
    }
    if(isset($parts['path'])){
        $path = explode('/', trim($parts['path'], '/'));
        return $path[count($path)-1];
    }
    return false;
}