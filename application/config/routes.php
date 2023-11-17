<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MANAGER','luffy');
$route['default_controller'] = 'Home';

/*ADMIN*/
$route[MANAGER]           = 'manager/dashboard';
$route[MANAGER.'/(:any)'] = 'manager/$1';
$route[MANAGER.'/(:any)/(:any)'] = 'manager/$1/$2';
$route[MANAGER.'/(:any)/(:any)/(:any)'] = 'manager/$1/$2/$3';
$route[MANAGER.'/(:any)/(:any)/(:any)/(:any)'] = 'manager/$1/$2/$3/$4';//products/attrib_upload_file_ajax/1/4
$route['manager/(:any)'] = '';
$route['manager'] = '';
/*ADMIN*/
$route['napdiem']	= 'Home/napdiem';
$route['trac-nghiem']	= 'Home/tracnghiem';
$route['clear']	= 'Home/clear';

$route['404_override'] = 'Home/error_404';
$route['translate_uri_dashes'] = FALSE;
