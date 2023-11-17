<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
/*
|--------------------------------------------------------------------------
| @nhocru : cấu hình để nén html đầu ra
| @nhocru : cấu hình lại $config['enable_hooks'] = TRUE;
|--------------------------------------------------------------------------


$hook['display_override'][] = array(
	'class' => '',
	'function' => 'compress',
	'filename' => 'compress.php',
	'filepath' => 'hooks'
	);
$hook['display_override'][] = array(
	'class' => '',
	'function' => 'cachefile',
	'filename' => 'cachefile.php',
	'filepath' => 'hooks'
	);	
	
$hook['display_override'][] = array(
		'class' => '',
		'function' => 'CI_Minifier_Hook_Loader',
		'filename' => 'CI_Minifier.php',
		'filepath' => ''
	);	
*/