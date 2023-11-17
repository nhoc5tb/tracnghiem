<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Module_bttkd_widget extends MY_Widget 
{
	public $wget;//đặt wget cho đỡ trùng với controller
	
	function index($params){		
		if($this->agent->is_mobile()){
			$template = $this->data['interface'].'/widgets/'.str_replace("_widget","",__CLASS__);//biến giao diện mobile				
		}else{
			$template = $this->data['interface'].'/widgets/'.str_replace("_widget","",__CLASS__);//biến giao diện desktop
		}	
		$this->load->view(strtolower($template),$this->wget);	
	}
	
}