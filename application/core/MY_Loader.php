<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."third_party/MX/Loader.php";

require APPPATH.'core/MY_Widget.php';

class MY_Loader extends MX_Loader {
	
	public function widget($widget_directory, $agrs = array()) 
		{
			// duong dan den file file controller widget
			$path = APPPATH . 'widgets/' . $widget_directory . '.php';
			
			// Ten controller widget
			$class_name = ucfirst(str_replace('/', '_', $widget_directory)) . '_widget';
	
			// kiem tra wget co ton tai ko
			if (!file_exists($path)) {
				show_error('The Widget ' . $path . ' Not Found');
			}
	
			//--------------------------------
			// Tao duong dan de load file view trong widget
			$this->_ci_view_paths = array(APPPATH . 'views/' => TRUE);
			
			//--------------------------------
			// Load Widget
			require_once($path);
	
			if (!class_exists($class_name)) {
				show_error("Class Name Widget $class_name Not Found, URL Is $path");
			}
	
			$MD = new $class_name;
	
			if (!method_exists($MD, 'index')) {
				show_error("Method Index Of Widget $class_name Not Found, URL Is $path");
			}
	
			ob_start();
			call_user_func_array(array($MD, 'index'), $agrs);
			$content = ob_get_contents();if (ob_get_length() > 0 ) {ob_end_clean();} 
			
	
			// Tra lai phuong thuc load views cho he thong CI
			$this->_ci_view_paths = array(APPPATH . 'views/' => TRUE);
	
			return $content;
		}
}