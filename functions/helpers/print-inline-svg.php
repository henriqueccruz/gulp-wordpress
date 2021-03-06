<?php
/**
 * Prints inline SVGs for styling and better organisation
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

function get_svg_ico($ico_name, $attr) {

	if(is_array($ico_name) && array_key_exists('url', $ico_name)) {
		$path = $ico_name['url'];
	} else {
		$path = get_stylesheet_directory() ."/assets/images/";
		$path .= ($attr && array_key_exists('dir', $attr)) ? "{$attr['dir']}/" : "";
		$path .= "{$ico_name}.svg";
	}

	
	$svg_markup = file_get_contents( $path );

	return $svg_markup;
}

function print_svg_ico($ico_name, $attr = NULL) {

	echo get_svg_ico($ico_name, $attr);

}