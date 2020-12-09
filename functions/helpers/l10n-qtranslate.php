<?php
/**
 * qTranslate-related functions
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

if(class_exists('QTX_Translator'))
	define('CURRENT_LANGUAGE', qtranxf_getLanguage());