<?php
/**
 * Prints language selection menu
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

function get_lang_menu() {

	$pt_BR_url = home_url();
	$en_US_url = home_url('/en');

	$lang_selection = "<a href='{$pt_BR_url}' class='".((CURRENT_LANGUAGE == 'pb') ? 'active-lang' : '')."'>PT</a> | <a href='{$en_US_url}' class='".((CURRENT_LANGUAGE == 'en') ? 'active-lang' : '')."'>EN</a>";
	return $lang_selection;

}