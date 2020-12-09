<?php
/**
 * Cleans empty arrays
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

/*function array_filter_empty(&$element) {
    if (is_array($element)) {
        if ($key = key($element)) {
            $element[$key] = array_filter($element);
        }

        if (count($element) != count($element, COUNT_RECURSIVE)) {
            $element = array_filter(current($element), __FUNCTION__);
        }

        return $element;
    } else {
        return empty($element) ? false : $element;
    }
}*/

function array_filter_empty(array $array, callable $callback = null) {
    $array = is_callable( $callback ) ? array_filter( $array, $callback ) : array_filter( $array );
    foreach ( $array as &$value ) {
        if ( is_array( $value ) ) {
            $value = call_user_func( __FUNCTION__, $value, $callback );
        }
    }

    return $array;
}