<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function cachefile()
{	
	$CI =& get_instance();
	
 	if($CI->router->fetch_class() == "Home"){
		
		$buffer = $CI->output->get_output();
		
		$get = $CI->input->get();
		$_get = NULL;
		if($get){
			$_get = "_";
			foreach($get as $key=>$val){
				$_get .= $key."_".$val;
			}
		}
		$name_file_cache = $CI->rulib->coverNameFile(uri_string().$_get);
		if(!$name_file_cache)$name_file_cache = "index";
		
		if($CI->config->item('cache_file') && !$CI->cachefile->get($name_file_cache) ){
			if(strstr($buffer,'<!DOCTYPE HTML>')){
				$type = "html";
			}else{
				$type = "json";
			}
			$content_cache = array(
							  'html' => $buffer,
							  'meta' => array(
							  			"type"=>$type
							  			) 
							  );	
			if(is_array($get) && $type == "json")		
				$CI->cachefile->write($content_cache, $name_file_cache , $CI->config->item('cache_default_expires'));
			if($_get == NULL && $type == "html")		
				$CI->cachefile->write($content_cache, $name_file_cache , $CI->config->item('cache_default_expires'));	
		}	
	 
		$CI->output->set_output($buffer);
		$CI->output->_display();
		
	}else{
		
		$buffer = $CI->output->get_output();
		$CI->output->set_output($buffer);
		$CI->output->_display();
		
	}
}
 
/* End of file compress.php */
/* Location: ./system/application/hooks/compress.php */