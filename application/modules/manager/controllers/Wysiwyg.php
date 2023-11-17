<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wysiwyg extends Admin_Controller {
	
	public function __construct(){ 
        parent::__construct(); 	
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	
		$this->data['config_upload']['dir'] = ROOT_DIR.'upload/dataimg/'.md5($this->data['auth']->username);
		$this->data['config_upload']['dirweb'] = "dataimg/".md5($this->data['auth']->username);
		
	} 

	public function index(){
		$folder = $this->input->post("folder");
		if($folder){
			$this->config->load('template');	
			$folder = $this->config->item($folder);
			if(!empty($folder))
				$this->data['config_upload'] = $folder;	
		}
		$json = array();
		if(is_dir($this->data['config_upload']['dir'])){
			$files = array_filter(glob($this->data['config_upload']['dir'].'/*'));
			$supported_format = array('gif','jpg','jpeg','png');
			
			foreach($files as $row){				
				if($row != '.' && $row != '..'){
					$ext = strtolower(pathinfo($row, PATHINFO_EXTENSION));
					if (in_array($ext, $supported_format)){
						$json[] = array(
							"url"   => base_url()."upload/".$this->data['config_upload']["dirweb"]."/".basename($row),
							"thumb" => base_url()."upload/".$this->data['config_upload']["dirweb"]."/".basename($row),
							"tag"   => date("d-m-Y",filemtime($row))
						);
					}					
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(stripslashes(json_encode($json)));
	}
	
	
	public function upload(){
		$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'file');	
		$json = array();
		
		if($fileimg['status'] == 200){
			$json = array("link"=>base_url()."upload/".$this->data['config_upload']["dirweb"]."/".$fileimg["src"]);
		}
		$this->output->set_content_type('application/json')->set_output(stripslashes(json_encode($json)));
	}
	
	public function delete(){
		$file = $this->input->post("src");
	
		if(strpos($file,base_url()) != false){
			$supported_format = array('gif','jpg','jpeg','png');
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if (in_array($ext, $supported_format)){
				$url_sv = str_replace(base_url(), "",$file);
				@unlink($url_sv);
				$json = array("true");
			}else{
				$json = array("false");
			}
		}else{
			$json = array("false");
		}	
		$this->output->set_content_type('application/json')->set_output(stripslashes(json_encode($json)));	
	}
	function dmUploader(){
		
	}

}