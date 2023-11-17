<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function compress()
{	
	$CI =& get_instance();
	
 	if($CI->router->fetch_class() == "Home" && $CI->router->fetch_method() != "ajaxpost"){
		
		$buffer = $CI->output->get_output();
		
		$search = array(
			'/\n/',			// replace end of line by a space
			'/\>[^\S ]+/s',		// strip whitespaces after tags, except space
			'/[^\S ]+\</s',		// strip whitespaces before tags, except space
			'/(\s)+/s'		// shorten multiple whitespace sequences
		  );
	 
		 $replace = array(
			' ',
			'>',
			'<',
			'\\1'
		  );
	 
		$buffer = preg_replace($search, $replace, $buffer);
		$CI->output->set_output($buffer);
		
	}
	
}
 
/* End of file compress.php */
/* Location: ./system/application/hooks/compress.php */