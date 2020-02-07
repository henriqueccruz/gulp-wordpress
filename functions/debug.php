<?php
/**
 * Debugging tools
 *
 * @author   Tinpix
 * @version  1.0.0
 * @package  agencia-plug
 */

/**
 * Pretty printing debugging tool
 */
function pr( $var ) {
	print '<pre>';
	print_r( $var );
	print '</pre>';
}
