<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Module_slider_widget extends MY_Widget 
{
	public $wget;//đặt wget cho đỡ trùng với controller
	
	function index($params){
		
		$this->config->load('template');
		$template = $this->config->item('template_name');
		
		$this->wget['dirweb'] = $this->config->item('image_ads');
		
		$this->load->model('ads_model');
		$params = json_decode($params);
		
		$this->wget['ads'] = $this->ads_model->get_by(array('id_group'=>$params[0]));
		
		if(empty($this->wget['ads'])){
			$this->wget['getcsdl'] = false;
		}else{			
			foreach($this->wget['ads'] as $key=>$row){
				$this->wget['getcsdl'][$key] = new stdClass();
				$this->wget['getcsdl'][$key] = $row;
				if( empty($row->width) ) 
					$this->wget['getcsdl'][$key]->width = '100%';
				else
					$this->wget['getcsdl'][$key]->width = $row->width;
				
				if( empty($row->height) ) 
					$this->wget['getcsdl'][$key]->height = '100%';
				else
					$this->wget['getcsdl'][$key]->height = $row->height;
			}
		}//if check rong ads
		
		if(@$this->wget['getcsdl']){
			if($this->agent->is_mobile()){
				$template = $this->data['interface'].'/widgets/'.str_replace("_widget","",__CLASS__);//biến giao diện mobile
				
			}else{
				$template = $this->data['interface'].'/widgets/'.str_replace("_widget","",__CLASS__);//biến giao diện desktop
			}
		
			$this->load->view(strtolower($template),$this->wget);
		}
    	
	}
}