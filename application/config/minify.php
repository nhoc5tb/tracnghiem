<?php
/**
 * Minify config Class
 *
 * PHP Version 5.3
 *
 * @category  PHP
 * @package   Controller
 * @author    Slawomir Jasinski <slav123@gmail.com>
 * @copyright 2015 All Rights Reserved SpiderSoft
 * @license   Copyright 2015 All Rights Reserved SpiderSoft
 * @link      http://www.spidersoft.com.au/projects/codeigniter-minify/
 */

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Minify config file
 *
 * @category  PHP
 * @package   Controller
 * @author    Slawomir Jasinski <slav123@gmail.com>
 * @copyright 2015 All Rights Reserved SpiderSoft
 * @license   Copyright 2015 All Rights Reserved SpiderSoft
 * @link      http://www.spidersoft.com.au/projects/codeigniter-minify/
 */
$config['enabled'] = FALSE;
// output path where the compiled files will be stored (default value: 'assets')
$config['assets_dir'] = '';

// optional - path where the compiled css files will be stored (default value: '' - for backward compatibility)
$config['assets_dir_css'] = 'css'; 

// optional - path where the compiled js files will be stored (default value: '' - for backward compatibility)
$config['assets_dir_js'] = 'js';     

// where to look for css files (default value: 'assets/css')
$config['css_dir'] = 'css';

// where to look for js files (default value: 'assets/js')
$config['js_dir'] = 'js';

// default file name for css (default value: 'style.css')
$config['css_file'] = 'styles.css';

// default file name for js (default value: 'scripts.js')
$config['js_file'] = 'scripts.js';

// use automatic file names (default value: 'FALSE')
$config['auto_names'] = FALSE;

// compress files or not (default value: 'TRUE')
$config['compress'] = TRUE;

$config['versioning'] = FALSE;

// compression engine setting (default values: 'minify' and 'closurecompiler')
$config['compression_engine'] = array(
	'css' => 'minify', // minify || cssmin
	'js'  => 'closurecompiler' // closurecompiler || jsmin || jsminplus
);

// when you use closurecompiler as compression engine you can choose compression level (default value: 'SIMPLE_OPTIMIZATIONS')
// avaliable options: "WHITESPACE_ONLY", "SIMPLE_OPTIMIZATIONS" or "ADVANCED_OPTIMIZATIONS"
$config['closurecompiler']['compilation_level'] = 'SIMPLE_OPTIMIZATIONS';


// End of file minify.php
// Location: ./application/config/minify.php
