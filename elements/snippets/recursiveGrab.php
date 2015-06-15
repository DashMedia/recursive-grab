<?php
/**
 * @name recursiveGrab
 * @description Get TV values recursivly weith an optional fallback document/tv combination
 *
 * USAGE
 *
 *  [[recursiveGrab? &id=`[[+id]]` &tv=`myTv` &fallbackId=`[[++site_start]]` &fallbackTv=`fallbackTv`]]
 *
 *
 * Copyright 2015 by Jason Carney <jason@dashmedia.com.au>
 *
 *
 * Variables
 * ---------
 * @var $modx modX
 * @var $scriptProperties array
 *
 * @package recursiveGrab
 */
// Your core_path will change depending on whether your code is running on your development environment
// or on a production environment (deployed via a Transport Package).  Make sure you follow the pattern
// outlined here. See https://github.com/craftsmancoding/repoman/wiki/Conventions for more info
$core_path = $modx->getOption('recursivegrab.core_path', null, MODX_CORE_PATH.'components/recursivegrab/');
include_once $core_path .'/vendor/autoload.php';

require_once $core_path.'/lib/RecursiveGrab.php';

$tvName = $modx->getOption('tv',$scriptProperties,null);

if(!is_null($tvName)){
	$rGrab = new RecursiveGrab($modx, $scriptProperties);
	return $rGrab->get($tvName);
} else {
	return "";
}