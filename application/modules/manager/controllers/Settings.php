<?php

class Settings extends Admin_Controller{

	var $data = array();

	function __construct(){
		parent::__construct();
		$this->load->model('config_model');
		$this->data['active_config'] = "class='active'";
		$this->data['controller_title'] = "Cấu Hình";
		$this->data['title'] = "Cấu hình website";	
	}	
	function index()
	{
		try {
			$this->data['title'] = "Cấu hình thẻ Meta";	
			
			$input = $this->input->post();
			
			$this->data['update'] = $this->input->get('update');
			
			$this->data['getcsdl'] = $this->config_model->getconfig();
			
			if(!empty($input)){
				$config = array();
				foreach($input as $key => $row){
					array_push($config,array('key' => $key,'value' => $row));
				}
				
				$this->config_model->upconfig($config);
				
				redirect($this->data['module'].'/'.$this->data['controller']);
			}
			
			$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
			 
		} catch (Exception $e) {
			echo $e->getMessage(); die();
		}
	}
	
	function web()
	{
		try {
			$this->data['title'] = "Cấu hình thẻ Web";	
			
			$input = $this->input->post();
			
			$this->data['update'] = $this->input->get('update');
			
			$this->data['getcsdl'] = $this->config_model->getconfig();
			
			if(!empty($input)){
				$config = array();
				foreach($input as $key => $row){
					array_push($config,array('key' => $key,'value' => $row));
				}
				
				$this->config_model->upconfig($config);
				
				redirect($this->data['module'].'/'.$this->data['controller']);
			}
			
			$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
			 
		} catch (Exception $e) {
			echo $e->getMessage(); die();
		}
	}
	
	function messenger()
	{
		$this->data['title'] = "Cấu hình ngôn ngữ";	
		$this->load->model('Messenger_model');
		$this->data['getcsdl'] = $this->Messenger_model->get();
		
		$input = $this->input->post();
		
		$setcsdl = array();
		
		if(!empty($input)){
			foreach($input as $key => $row){
				array_push($setcsdl,array('key' => base64_decode($key),'value' => $row));
			}
			$this->Messenger_model->update_batch($setcsdl);	
			redirect($this->data['module'].'/'.$this->data['controller'].'/'.$this->data['action']."?r=".rand(1,10));
		}
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
}